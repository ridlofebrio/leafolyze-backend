<?php

use App\Http\Middleware\EnsureUserRole;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

Route::get('/', function () {
    return view('pages.landing-pages.index');
});

Route::get('/dashboard', function () {
    return view('pages.dashboard.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'handleLogin'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('pages.dashboard.index');
    })->name('dashboard');

//    Route::get()/
});

// Route::get('/debug-auth', function () {
//     $user = \App\Models\User::where('email', 'admin@example.com')->first();
//     $testPassword = 'password123';

//     dd([
//         'user_exists' => $user !== null,
//         'password_check' => Hash::check($testPassword, $user->password),
//         'current_auth' => Auth::check(),
//         'session_data' => session()->all(),
//         'session_id' => session()->getId(),
//         'cookies' => request()->cookies->all(),
//     ]);
// });
