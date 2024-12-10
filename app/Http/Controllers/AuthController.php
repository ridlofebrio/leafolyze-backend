<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Services\Interfaces\AuthServiceInterface;
use App\Http\Resources\Api\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\UserDetail;
use App\Models\Shop;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService;
    }

    public function login()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function registerPenjual(Request $request)
    {
        DB::beginTransaction();
        try {
            $user = User::create([
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
                'access' => 'penjual',
            ]);

            $user->userDetail()->create([
                'name' => $request['name'],
            ]);

            $user->shop()->create([
                'name' => 'Toko Tanaman Sehat',
                'address' => '',
                'description' => '',
                'operational' => '',
            ]);

            Auth::guard('web')->login($user);
            DB::commit();

            return redirect('/penjual');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Registration failed']);
        }
    }

    public function handleLogin(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();
            session()->put('auth.password_confirmed_at', time());

            return $this->redirectBasedOnRole(Auth::guard('web')->user());
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
