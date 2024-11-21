<?php

use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\DetectionController;
use App\Http\Controllers\Api\MachineLearningImageController;
use App\Http\Controllers\Api\AuthController;
use \App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProfileController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);

    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('me', [AuthController::class, 'me']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
    });
});

Route::group(['prefix' => 'articles', 'middleware' => 'auth:api'], function () {
    Route::get('/', [ArticleController::class, 'index']);
    Route::get('/{id}', [ArticleController::class, 'show']);

    // Admin only routes
    Route::middleware(['auth:api'])->group(function () {
        Route::post('/', [ArticleController::class, 'store']);
        Route::put('/{id}', [ArticleController::class, 'update']);
        Route::delete('/{id}', [ArticleController::class, 'destroy']);
    });
});

Route::group(['prefix' => 'products', 'middleware' => 'auth:api'], function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::get('/{id}', [ProductController::class, 'show']);
    Route::get('/shop/{shopId}', [ProductController::class, 'byShop']);
    Route::get('/disease/{diseaseId}', [ProductController::class, 'byDisease']);

    // Penjual only routes
    Route::middleware(['auth:api'])->group(function () {
        Route::post('/', [ProductController::class, 'store']);
        Route::put('/{id}', [ProductController::class, 'update']);
        Route::delete('/{id}', [ProductController::class, 'destroy']);
    });
});

Route::group(['prefix' => 'detections', 'middleware' => 'auth:api'], function () {
    Route::get('/', [DetectionController::class, 'index']);
    Route::get('/{id}', [DetectionController::class, 'show']);
    Route::post('/', [DetectionController::class, 'store']);
    Route::put('/{id}', [DetectionController::class, 'update']);
    Route::delete('/{id}', [DetectionController::class, 'destroy']);
});

Route::group(['prefix' => 'profile', 'middleware' => 'auth:api'], function () {
    Route::get('/', [ProfileController::class, 'show']);
    Route::post('/update', [ProfileController::class, 'update']);
    Route::post('/password', [ProfileController::class, 'updatePassword']);
});
