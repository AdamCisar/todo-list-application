<?php

use App\Features\Auth\Controllers\UserAuthController;
use App\Features\Todo\Controllers\TodoController;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

Route::fallback(function () {
    return response()->json([
        'success' => false,
        'message' => 'Endpoint not found.',
        'data' => null,
    ], Response::HTTP_NOT_FOUND);
});

/**
 * AUTHENTICATION
 */
Route::prefix('auth')->group(function () {
    Route::post('register', [UserAuthController::class, 'register']);
    Route::post('login', [UserAuthController::class, 'login']);
    Route::post('logout',[UserAuthController::class,'logout'])
        ->middleware('auth:sanctum');
});

/**
 * TODOS
 */
Route::apiResource('todos', TodoController::class)
    ->middleware('auth:sanctum');