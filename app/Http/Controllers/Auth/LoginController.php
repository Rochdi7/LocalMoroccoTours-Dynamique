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
        return '/admin';
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
