<?php

use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\DetectionController;
use App\Http\Controllers\Api\DiseaseController;
use App\Http\Controllers\Api\AuthController;
use \App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\ShopController;
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

Route::group(['prefix' => 'articles'], function () {
    Route::get('/', [ArticleController::class, 'index']);
    Route::get('/{id}', [ArticleController::class, 'show']);

    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('/', [ArticleController::class, 'store']);
        Route::post('/{id}', [ArticleController::class, 'update']);
        Route::delete('/{id}', [ArticleController::class, 'destroy']);
    });
});

Route::group(['prefix' => 'products'], function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::get('/{id}', [ProductController::class, 'show']);
    Route::get('/shop/{shopId}', [ProductController::class, 'byShop']);
    Route::get('/disease/{diseaseId}', [ProductController::class, 'byDisease']);

    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('/', [ProductController::class, 'store']);
        Route::post('/{id}', [ProductController::class, 'update']);
        Route::delete('/{id}', [ProductController::class, 'destroy']);
    });
});

Route::group(['prefix' => 'detections'], function () {
    Route::get('/', [DetectionController::class, 'index']);
    Route::get('/{id}', [DetectionController::class, 'show']);
    Route::post('/', [DetectionController::class, 'store']);
    Route::post('/{id}', [DetectionController::class, 'update']);
    Route::delete('/{id}', [DetectionController::class, 'destroy']);
    Route::group(['middleware' => 'auth:api'], function () {

    });
});

Route::group(['prefix' => 'diseases'], function () {
    Route::get('/', [DiseaseController::class, 'index']);
    Route::get('/{id}', [DiseaseController::class, 'show']);
});

Route::group(['prefix' => 'profile', 'middleware' => 'auth:api'], function () {
    Route::get('/', [ProfileController::class, 'show']);
    Route::post('/update', [ProfileController::class, 'update']);
    Route::post('/password', [ProfileController::class, 'updatePassword']);
});

Route::group(['prefix' => 'shop'], function () {
    Route::get('/', [ShopController::class, 'index']);
    Route::get('/{id}', [ShopController::class, 'show']);

    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('/', [ShopController::class, 'store']);
        Route::post('/{id}', [ShopController::class, 'update']);
        Route::delete('/{id}', [ShopController::class, 'destroy']);
    });
});
