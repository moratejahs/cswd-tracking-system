<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.admin-login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (!Auth::attempt($credentials)) {
            return back()->with([
                'error' => 'Invalid credentials.',
            ]);
        }

        return to_route('index.home');
    }

    public function logout()
    {
        Auth::logout();

        return to_route('admin-login.form');
    }
}
