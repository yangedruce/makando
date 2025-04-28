<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;

class RestaurantRegistrationController extends Controller
{
    public function create()
    {
        return view('auth.restaurant-register');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|lowercase|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'restaurant_name' => 'required|string|max:255',
            'address' => 'required|string|max:255', 
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_force_password_change' => false,
        ]);

        $managerRole = Role::where('name', 'Restaurant Manager')->first();
        $user->roles()->attach($managerRole);

        Restaurant::create([
            'name' => $request->restaurant_name,
            'address' => $request->address, 
            'user_id' => $user->id,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}