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
    Route::post('register', [UserAuthController::class, 'register'])->middleware('throttle:3,1');
    Route::post('login', [UserAuthController::class, 'login'])->middleware('throttle:5,1');
    Route::post('logout', [UserAuthController::class, 'logout'])
        ->middleware('auth:sanctum');
});

/** TODOS */
Route::middleware('auth:sanctum')
    ->prefix('todos')
    ->group(function () {
        Route::prefix('{todo}')
            ->where(['todo' => '[1-9]+'])
            ->group(function () {
                Route::get('/', [TodoController::class, 'show']);
                Route::put('/', [TodoController::class, 'update']);
                Route::delete('/', [TodoController::class, 'destroy']);
                Route::patch('/toggle', [TodoController::class, 'toggle']);
            });

        Route::get('/', [TodoController::class, 'index']);
        Route::post('/', [TodoController::class, 'store']);

        Route::get('stats', [TodoController::class, 'stats']);
        Route::get('search/{query}', [TodoController::class, 'search']);
    });
