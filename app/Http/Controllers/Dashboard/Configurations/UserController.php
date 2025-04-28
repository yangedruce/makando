<?php

namespace App\Http\Controllers\Dashboard\Configurations;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;

use App\Models\User;
use App\Models\Role;
use App\Models\RecordLog;

use App\Notifications\UserCreated;
use App\Notifications\UserPasswordUpdated;

class UserController extends Controller
{
    private $modelName;

    /**
     * Initialize parameters.
     */
    public function __construct()
    {
        $this->modelName = 'User';
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::orderBy('name')->paginate(10);
        $roles = Role::all();
        
        return view('dashboard.config.user.index')->with([ 
            'users' => $users,
            'roles' => $roles,
            'request' => null 
        ]);
    }
    
    /**
     * Search for resource.
     */
    public function search(Request $request)
    {
        $keyword = $request->keyword;
        $users = User::query();

        // Search for user that match the query terms.
        if ($request->has('keyword')) {
            foreach (getKeywordTerms($keyword) as $term) {
                $users->where('name', 'LIKE', "%$term%");
            }
        }

        // Filter user by role.
        if ($request->has('role_id')) {
            $users->whereHas('roles', function ($query) use ($request) {
                $query->whereIn('role_id', $request->role_id);
            });
        }

        $users = $users->orderBy('name')->paginate(10);
        $roles = Role::all();

        return view('dashboard.config.user.index')->with([ 
            'users' => $users,
            'roles' => $roles,
            'request' => $request,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        
        return view('dashboard.config.user.create')->with([ 'roles' => $roles ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role_id' => ['required', 'array'],
            'role_id.*' => ['exists:roles,id']
        ]);

        // If role does not exist.
        $roles = Role::whereIn('id', $request->role_id)->pluck('id')->all();
        if (!empty(array_diff($request->role_id, $roles))) {
            return back()->withInput()->with('alert', __('One or more role records do not exist.'));
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_force_password_change' => false,
            'email_verified_at' => date('Y-m-d H:i:s')
        ]);

        $user->roles()->attach($request->role_id);
        $user->notify(new UserCreated($user, $request->password));

        storeActivityLog('Created a record in User submodule.', route('dashboard.config.user.show', $user->id));
        return redirect()->route('dashboard.config.user.index')->with('alert', __('Record has been added.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::withTrashed()->find($id);

        // If user does not exist.
        if (!$user) {
            return redirect()->back()->with('alert', __('Record does not exist.'));
        }
        
        $recordLogs = getRecordLog($this->modelName, $id);

        return view('dashboard.config.user.show')->with([
            'user' => $user,
            'recordLogs' => $recordLogs,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::find($id);

        // If user does not exist.
        if (!$user) {
            return redirect()->back()->with('alert', __('Record does not exist.'));
        }

        // If user is not editable.
        if (!$user->is_editable && $user->is_editable !== null) {
            return redirect()->back()->with('alert', __('Unable to edit this record.'));
        }

        $roles = Role::all();

        return view('dashboard.config.user.edit')->with([
            'user' => $user,
            'roles' => $roles,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::find($id);

        // If user does not exist.
        if (!$user) {
            return redirect()->back()->with('alert', __('Record does not exist.'));
        }

        // If role does not exist.
        $roles = Role::whereIn('id', $request->role_id)->pluck('id')->all();
        if (!empty(array_diff($request->role_id, $roles))) {
            return back()->withInput()->with('alert', __('One or more role records do not exist.'));
        }
        
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users')->ignore($user)],
            'role_id' => ['required', 'array'],
            'role_id.*' => ['exists:roles,id']
        ]);

        $errors = $validator->errors();

        // If update password.
        if ($request->is_update_password == true) {
            $validatePassword = Validator::make($request->all(), [
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);

            if ($validatePassword->fails()) {
                $errors = $errors->merge($validatePassword->errors());
            }
        }

        // If there are validation errors.
        if ($errors->isNotEmpty()) {
            throw ValidationException::withMessages($errors->messages());
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // If password is updated.
        if ($request->is_update_password == true) {
            $user->update([
                'password' => Hash::make($request->password),
                'is_force_password_change' => $request->is_force_password_change == true,
            ]);

            $user->notify(new UserPasswordUpdated($user, $request->password));
        }

        $user->roles()->sync($request->role_id);

        storeActivityLog('Updated a record in User submodule.', route('dashboard.config.user.show', $user->id));
        return redirect()->route('dashboard.config.user.index')->with('alert', __('Record has been updated.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $removeSession = false;
        $user = User::find($id);
        
        // If user does not exist.
        if (!$user) {
            return redirect()->route('dashboard.config.user.index')->with('alert', __('Record does not exist.'));
        }
        
        // If user is last super admin.
        if ($user->isLastSuperAdmin()) {
            return redirect()->back()->with('alert', __('Unable to delete this record because there must at least be 1 super admin.'));
        } 
        
        // If targeted user is current logged in user.
        if ($user->id == Auth::user()->id) {
            Auth::logout();
            $removeSession = true;
        }
        
        $user->delete();

        // If session exist.
        if ($removeSession) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        storeActivityLog('Deleted a record in User submodule.', route('dashboard.config.user.show', $id));
        return redirect()->route('dashboard.config.user.index')->with('alert', __('Record has been deleted.'));
    }
}
