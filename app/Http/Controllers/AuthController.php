<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }
        return view('auth.login');
    }

    public function handleLogin(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();
            session()->put('auth.password_confirmed_at', time());

            return match (Auth::guard('web')->user()->access) {
                'admin' => redirect('/admin'),
                'penjual' => redirect('/penjual'),
                default => redirect('/dashboard'),
            };
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    private function redirectBasedOnRole($user)
    {
        if (!$user) {
            return redirect()->route('login');
        }

        return match ($user->access) {
            'admin' => redirect()->intended('/admin'),
            'penjual' => redirect()->intended('/penjual'),
            default => redirect()->intended('/dashboard'),
        };
    }

    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect('/login');
    }
}
