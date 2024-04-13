<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Auth;

class LoginResponse implements LoginResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        // Ensure the user is authenticated
        if (Auth::check()) {
            // Check if the user is an admin
            if (Auth::user()->type == 'admin') {
                // Redirect to the admin dashboard
                return redirect()->intended('admin.dashboard');
            } else {
                // Redirect to the user dashboard
                return redirect()->intended('dashboard');
            }
        }

        // If the user is not authenticated, redirect to the login page with an error message
        return redirect()->route('login')->withErrors(['message' => 'Login failed. Please try again.']);
    }
}
