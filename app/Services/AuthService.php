<?php

namespace App\Services;

use App\Models\User;
use App\Services\Interfaces\AuthServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthService implements AuthServiceInterface
{
    public function login(array $credentials)
    {
        try {
            if (!$token = Auth::attempt($credentials)) {
                throw new \Exception('Invalid credentials');
            }

            return $this->respondWithToken($token);
        } catch (\Exception $e) {
            Log::error('Login error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function register(array $data)
    {
        try {
            $user = User::create([
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'access' => $data['access'] ?? 'petani',
            ]);

            // Create user details
            $user->userDetail()->create([
                'name' => $data['name'],
                'birth' => $data['birth'],
                'gender' => $data['gender'],
                'address' => $data['address'],
                'gambarUrl' => $data['gambarUrl'] ?? null,
            ]);

            Auth::login($user);
            $token = Auth::tokenById($user->id);
            return $this->respondWithToken($token);
        } catch (\Exception $e) {
            Log::error('Registration error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function logout()
    {
        try {
            Auth::logout();
            return true;
        } catch (\Exception $e) {
            Log::error('Logout error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function refresh()
    {
        try {
            return $this->respondWithToken(Auth::refresh());
        } catch (\Exception $e) {
            Log::error('Token refresh error: ' . $e->getMessage());
            throw $e;
        }
    }

    private function respondWithToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60,
            'user' => Auth::user()->userDetail
        ];
    }
}
