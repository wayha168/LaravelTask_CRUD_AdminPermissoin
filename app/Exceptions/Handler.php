<?php

namespace App\Exceptions;

use App\Responses\ResponseService;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     */
    public function render($request, Throwable $e): Response
    {
        // === API RESPONSES (JSON) ===
        if ($request->expectsJson() || $request->is('api/*')) {
            return $this->apiExceptionResponse($request, $e);
        }

        // === WEB RESPONSES (HTML) ===
        return parent::render($request, $e);
    }

    /**
     * Handle API-specific exception responses.
     */
    protected function apiExceptionResponse(Request $request, Throwable $e): Response
    {
        $status = $this->getStatusCode($e);
        $message = $this->getMessage($e, $status);

        // Validation errors
        if ($e instanceof \Illuminate\Validation\ValidationException) {
            return ResponseService::error(
                message: 'Validation failed',
                status: 422,
                data: $e->errors()
            );
        }

        return ResponseService::error(
            message: $message,
            status: $status
        );
    }

    /**
     * Get HTTP status code from exception.
     */
    protected function getStatusCode(Throwable $e): int
    {
        // 1. Symfony HttpExceptionInterface (most Laravel exceptions)
        if ($e instanceof \Symfony\Component\HttpKernel\Exception\HttpExceptionInterface) {
            return $e->getStatusCode();
        }

        // 2. Laravel-specific: ModelNotFoundException → 404
        if ($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
            return 404;
        }

        // 3. ValidationException → 422
        if ($e instanceof \Illuminate\Validation\ValidationException) {
            return 422;
        }

        // 4. AuthenticationException → 401
        if ($e instanceof \Illuminate\Auth\AuthenticationException) {
            return 401;
        }

        // 5. AuthorizationException → 403
        if ($e instanceof \Illuminate\Auth\Access\AuthorizationException) {
            return 403;
        }

        // 6. MethodNotAllowedHttpException → 405
        if ($e instanceof \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException) {
            return 405;
        }

        // 7. Fallback: 500
        return 500;
    }

    /**
     * Get user-friendly message.
     */
    protected function getMessage(Throwable $e, int $status): string
    {
        return match ($status) {
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Resource not found',
            405 => 'Method not allowed',
            422 => 'Validation failed',
            500 => 'Server error',
            default => 'Something went wrong',
        };
    }
}
