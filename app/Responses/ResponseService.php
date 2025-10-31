<?php

namespace App\Responses;

use Illuminate\Http\JsonResponse;

class ResponseService
{
    public static function success(
        $data = null,
        string $message = 'Operation successful',
        int $status = 200,
        array $meta = []
    ): JsonResponse {
        return response()->json([
            'success' => true,
            'data'    => $data,
            'message' => $message,
            'meta'    => (object) $meta,
        ], $status);
    }

    public static function error(
        string $message = 'Operation failed',
        int $status = 400,
        $data = null,
        array $meta = []
    ): JsonResponse {
        return response()->json([
            'success' => false,
            'data'    => $data,
            'message' => $message,
            'meta'    => (object) $meta,
        ], $status);
    }

    public static function created($data, string $message = 'Created successfully'): JsonResponse
    {
        return self::success($data, $message, 201);
    }

    public static function deleted(string $message = 'Deleted successfully'): JsonResponse
    {
        return self::success(null, $message, 200);
    }

    public static function notFound(string $message = 'Resource not found'): JsonResponse
    {
        return self::error($message, 404);
    }

    public static function unauthorized(string $message = 'Unauthorized'): JsonResponse
    {
        return self::error($message, 401);
    }

    public static function forbidden(string $message = 'Forbidden'): JsonResponse
    {
        return self::error($message, 403);
    }
}
