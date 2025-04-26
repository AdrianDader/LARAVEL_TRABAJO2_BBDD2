<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\RepositoryController;
use App\Http\Controllers\Api\AuthController;



Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('repository', RepositoryController::class);
});



Route::post('/login', [AuthController::class, 'login']);
