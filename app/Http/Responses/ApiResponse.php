<?php

declare(strict_types=1);

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    public static function success(string $message, ?array $data, int $status): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    public static function error(string $error, ?array $errors, int $status): JsonResponse
    {
        return response()->json([
            'success' => false,
            'error' => $error,
            'errors' => $errors,
        ], $status);
    }
}
