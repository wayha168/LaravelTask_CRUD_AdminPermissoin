<?php

namespace App\Responses;

use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    protected function success($data = null, string $message = 'Success', int $status = 200, array $meta = []): JsonResponse
    {
        return ResponseService::success($data, $message, $status, $meta);
    }

    protected function error(string $message = 'Error', int $status = 400, $data = null, array $meta = []): JsonResponse
    {
        return ResponseService::error($message, $status, $data, $meta);
    }

    protected function created($data, string $message = 'Created'): JsonResponse
    {
        return ResponseService::created($data, $message);
    }

    protected function deleted(string $message = 'Deleted'): JsonResponse
    {
        return ResponseService::deleted($message);
    }

    protected function notFound(string $message = 'Not Found'): JsonResponse
    {
        return ResponseService::notFound($message);
    }
}
