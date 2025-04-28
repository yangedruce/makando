<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ForcePasswordChangeController extends Controller
{
    public function change()
    {
        if (Auth::check() && !Auth::user()->is_force_password_change) {
            return redirect()->route('dashboard');
        }
        return view('auth.change-password');
    }

    public function update(Request $request)
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => [
                'required', 
                Password::defaults(), 
                'confirmed',
                function ($attribute, $value, $fail) use ($request) {
                    if (Hash::check($value, Auth::user()->password)) {
                        $fail(__('The new password must be different from the current password.'));
                    }
                },
            ],
        ]);

        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->is_force_password_change = false; // Reset the flag after password change
        $user->save();

        return redirect()->route('dashboard')->with('alert', __('Password has been successfully updated!'));
    }
}
