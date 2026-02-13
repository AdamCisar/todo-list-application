<?php declare(strict_types=1);

namespace App\Http\Responses;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ApiResponse
{
    public static function success(string $message, ?array $data, int $status = Response::HTTP_OK): JsonResponse
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
