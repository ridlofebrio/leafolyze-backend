<?php

use App\Http\Controllers\Api\GambarMachineLearningController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

// public
Route::middleware(['throttle:6,1'])->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('logout', [AuthController::class, 'logout']);
});
Route::get('me', [AuthController::class, 'me']);

// protected
Route::middleware('auth:api')->group(function () {
    Route::apiResource('/machinelearning', GambarMachineLearningController::class)->except(['edit', 'create']);
    Route::apiResource('/obat', \App\Http\Controllers\Api\ObatController::class)->except(['edit', 'create']);
    Route::apiResource('/artikel', \App\Http\Controllers\Api\ArtikelController::class)->except(['edit', 'create']);
    Route::apiResource('/toko', \App\Http\Controllers\Api\TokoController::class)->except(['edit', 'create']);
});
