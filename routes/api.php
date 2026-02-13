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

/** AUTHENTICATION */
Route::prefix('auth')->group(function () {
    Route::post('register', [UserAuthController::class, 'register']);
    Route::post('login', [UserAuthController::class, 'login']);
    Route::post('logout', [UserAuthController::class, 'logout'])
        ->middleware('auth:sanctum');
});

/** TODOS */
Route::middleware('auth:sanctum')
    ->where(['todo' => '[1-9]+'])
    ->group(function () {
        // We need to exclude the 'update' method from the apiResource because we want to handle it separately to allow both PUT and PATCH methods. Otherwise the apiResource will create a route for PATCH /todos/{todo}
        Route::apiResource('todos', TodoController::class)->except(['update']);
        Route::put('todos/{todo}', [TodoController::class, 'update']);
        Route::patch('todos/{todo}/toggle', [TodoController::class, 'toggle']);

        Route::get('todos/stats', [TodoController::class, 'stats']);
    });
