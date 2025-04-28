<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('dashboard.profile.index', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        // If user update email.
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Update the user's profile information.
     */
    public function updateCustomer(Request $request): RedirectResponse
    {
        $request->validate([
            'phone_no' => ['required', 'numeric'],
            'address' => ['required'],
        ]);

        $user = $request->user();

        $user->customer->phone_no = $request->phone_no;
        $user->customer->address = $request->address;
        $user->customer->save();

        return Redirect::route('profile.edit')->with('status', 'customer-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);
        $user = $request->user();

        // If user is last admin.
        if ($user->isLastSuperAdmin()) {
            return redirect()->back()->with('alert',  __("Unable to delete this user as there must at least be 1 super admin."));
        } 

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Edit customer profile.
     */
    public function editManager(Request $request): View
    {
        return view('dashboard.profile.manager', [
            'user' => $request->user(),
        ]);
    }

}
