<?php

use App\Http\Controllers\Api\MachineLearningImageController;
use App\Http\Controllers\Api\AuthController;
use \App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;

// public
Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);

    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::get('profile', [AuthController::class, 'profile']);
    });
});

// protected
Route::middleware('auth:api')->group(function () {
    Route::get('me', [AuthController::class, 'me']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::apiResource('/products', ProductController::class)->except(['edit', 'create']);
    Route::apiResource('/machinelearning', MachineLearningImageController::class)->except(['edit', 'create']);
    Route::apiResource('/articles', \App\Http\Controllers\Api\ArticleController::class)->except(['edit', 'create']);
    Route::apiResource('/shop', \App\Http\Controllers\Api\ShopController::class)->except(['edit', 'create']);
});
