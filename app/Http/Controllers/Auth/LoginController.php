<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Custom redirect after login.
     */
    protected function redirectTo()
    {
        // Redirect admins to admin dashboard
        if (auth()->check() && auth()->user()->is_admin) {
            return '/admin';
        }

        // All other users go to the homepage
        return '/';
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
