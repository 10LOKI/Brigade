<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PlatController;
use App\Http\Controllers\Api\CategorieController;
use Illuminate\Support\Facades\Route;

//had les routes public
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

// hado protected
Route::middleware('auth:sanctum')->group(function () {

    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user',    [AuthController::class, 'user']);

    // Plats
    Route::apiResource('plats', PlatController::class);

    // Categories
    Route::apiResource('categories', CategorieController::class);
    Route::post('categories/{category}/plats', [CategorieController::class, 'associerPlats']);
});