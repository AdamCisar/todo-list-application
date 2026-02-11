<?php

use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

Route::fallback(function () {
    return response()->json([
        'success' => false,
        'message' => 'Endpoint not found.',
        'data' => null,
    ], Response::HTTP_NOT_FOUND);
});