<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class ValidateUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->hasRole('Customer')){
            if (empty($user->customer->phone_no) || empty($user->customer->address)) {
                if (!$request->routeIs('profile.edit')) {
                    return redirect()->route('profile.edit')->with('alert', __('Please complete your customer information before proceeding.'));
                }
            }
        }

        // if ($user->role === 'Manager') {
        //     // Assuming manager hasOne restaurant relationship
        //     if (!$user->restaurant) {
        //         if (!$request->is('/profile/manager/edit')) {
        //             return redirect()->route('profile.manager.edit');
        //         }
        //     }
        // }

        return $next($request);
    }
}
