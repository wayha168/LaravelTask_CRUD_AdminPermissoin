<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifiCsrfToken
{
    /**
     * Handle an incoming request.
     *
     * @var array<int, string>
     */
    protected $except = [
        'api/*'
    ];
}
