<?php

use App\Http\Controllers\Api\MachineLearningImageController;
use App\Http\Controllers\Api\AuthController;
use \App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;

// public
Route::middleware(['throttle:6,1'])->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('refresh', [AuthController::class, 'refresh']);
});

// protected
Route::middleware('auth:api')->group(function () {
    Route::get('me', [AuthController::class, 'me']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::apiResource('/products', ProductController::class)->except(['edit', 'create']);
    Route::apiResource('/article', \App\Http\Controllers\Api\ArticleController::class)->except(['edit', 'create']);
    Route::apiResource('/shop', \App\Http\Controllers\Api\ShopController::class)->except(['edit', 'create']);
    Route::apiResource('/machinelearning', MachineLearningImageController::class)->except(['edit', 'create']);
    Route::apiResource('/userdetail', \App\Http\Controllers\Api\UserDetailController::class)->except(['edit', 'create']);

});
