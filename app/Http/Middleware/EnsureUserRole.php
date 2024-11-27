<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserRole
{
    public function handle(Request $request, Closure $next, string ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if (!in_array($user->access, $roles)) {
            return match($user->access) {
                'admin' => redirect('/admin'),
                'penjual' => redirect('/penjual'),
                default => redirect('/dashboard'),
            };
        }

        return $next($request);
    }
}
