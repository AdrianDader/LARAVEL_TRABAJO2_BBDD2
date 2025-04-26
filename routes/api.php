<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\RepositoryController;
use App\Http\Controllers\Api\AuthController;


// rutas públicas
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// rutas privadas
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('repository', RepositoryController::class);
});




