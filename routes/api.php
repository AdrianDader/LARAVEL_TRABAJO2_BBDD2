<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\RepositoryController;

Route::apiResource('repository', RepositoryController::class);
