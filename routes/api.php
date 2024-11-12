<?php

use App\Http\Controllers\Api\GambarMachineLearningController;
use Illuminate\Support\Facades\Route;

Route::apiResource('/machinelearning', GambarMachineLearningController::class)->except(['edit', 'create']);
Route::apiResource('/obat', \App\Http\Controllers\Api\ObatController::class)->except(['edit', 'create']);
Route::apiResource('/artikel', \App\Http\Controllers\Api\ArtikelController::class)->except(['edit', 'create']);
