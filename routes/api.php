<?php

use App\Http\Controllers\Api\MachineLearningImageController;
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
    Route::apiResource('/product', \App\Http\Controllers\Api\ProductController::class)->except(['edit', 'create']);
    Route::apiResource('/machinelearning', MachineLearningImageController::class)->except(['edit', 'create']);
    Route::apiResource('/article', \App\Http\Controllers\Api\ArticleController::class)->except(['edit', 'create']);
    Route::apiResource('/shop', \App\Http\Controllers\Api\ShopController::class)->except(['edit', 'create']);
});
