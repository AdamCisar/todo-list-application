<?php

use App\Features\Auth\Controllers\UserAuthController;
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
 * AUTHENTICATION ROUTES
 */
Route::prefix('auth')->group(function () {
    Route::post('register', [UserAuthController::class, 'register']);
    Route::post('login', [UserAuthController::class, 'login']);
    Route::post('logout',[UserAuthController::class,'logout'])
        ->middleware('auth:sanctum');
});