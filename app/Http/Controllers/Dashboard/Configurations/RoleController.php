<?php

namespace App\Http\Controllers\Dashboard\Configurations;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Models\Permission;
use App\Models\Role;
use App\Models\RecordLog;
use App\Models\User;

class RoleController extends Controller
{
    private $modelName;

    /**
     * Initialize parameters.
     */
    public function __construct()
    {
        $this->modelName = 'Role';
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = Permission::all();
        $roles = Role::orderBy('name')->paginate(10);

        return view('dashboard.config.role.index')->with([ 'roles' => $roles ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::all();

        return view('dashboard.config.role.create')->with([ 'permissions' => $permissions ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:'.Role::class],
            'permission_id' => ['required', 'array'],
            'permission_id.*' => ['exists:permissions,id']
        ]);

        $role = Role::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        $role->permissions()->attach($request->permission_id);

        storeActivityLog('Created a record in Role submodule.', route('dashboard.config.role.show', $role->id));
        return redirect()->route('dashboard.config.role.index')->with('alert', __('Record has been added.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $role = Role::withTrashed()->find($id);

        // If role does not exist.
        if (!$role) {
            return redirect()->back()->with('alert', __('Record does not exist.'));
        }
        
        $permissions = Permission::all();
        $recordLogs = getRecordLog($this->modelName, $id);

        return view('dashboard.config.role.show')->with([
            'role' => $role,
            'permissions' => $permissions,
            'recordLogs' => $recordLogs
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role = Role::find($id);
        $permissions = Permission::all();

        // If role does not exist.
        if (!$role) {
            return redirect()->back()->with('alert', __('Record does not exist.'));
        }

        // If role is not editable.
        if (!$role->is_editable && $role->is_editable !== null) {
            return redirect()->route('dashboard.config.role.index')->with('alert', __('Unable to edit record.'));
        }

        return view('dashboard.config.role.edit')->with([
            'role' => $role,
            'permissions' => $permissions
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $role = Role::find($id);
        
        // If role does not exist.
        if (!$role) {
            return redirect()->back()->with('alert', __('Record does not exist.'));
        }

        // If role is not editable.
        if (!$role->is_editable && $role->is_editable !== null) {
            return redirect()->back()->with('alert', __('Unable to edit this record.'));
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('roles')->ignore($role)],
            'permission_id' => ['required', 'array'],
            'permission_id.*' => ['exists:permissions,id']
        ]);

        $role->name = $request->name;
        $role->description = $request->description;
        $role->save();
        $role->permissions()->sync($request->permission_id);

        storeActivityLog('Updated a record in Role submodule.', route('dashboard.config.role.show', $role->id));
        return redirect()->route('dashboard.config.role.index')->with('alert', __('Record has been updated.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::find($id);

        // If role does not exist.
        if (!$role) {
            return redirect()->back()->with('alert', __('Record does not exist.'));
        }

        // If role is not deletable.
        if (!$role->is_deletable && $role->is_deletable !== null) {
            return redirect()->back()->with('alert', __('Unable to delete this record.'));
        }

        // If role is assigned to user.
        if ($role->users()->exists()) {
            return redirect()->back()->with('alert', __('Unable to delete this record because it is assigned to some users.'));
        }

        $role->delete();

        storeActivityLog('Deleted a record in Role submodule.', route('dashboard.config.role.show', $id));
        return redirect()->route('dashboard.config.role.index')->with('alert', __('Record has been deleted.'));
    }
}
