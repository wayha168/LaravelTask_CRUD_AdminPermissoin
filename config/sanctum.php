<?php

return [

    'stateful' => explode(',', env('SANCTUM_STATEFUL_DOMAINS', '127.0.0.1,127.0.0.1:8000')),

    'guard' => ['api', 'web'],

    'expiration' => null,

    'token_prefix' => env('SANCTUM_TOKEN_PREFIX', ''),

    'middleware' => [
        'authenticate_session' => Laravel\Sanctum\Http\Middleware\AuthenticateSession::class,
        'encrypt_cookies'     => Illuminate\Cookie\Middleware\EncryptCookies::class,
        'validate_csrf_token' => Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class,
    ],

    // ← ADD THESE
    'stateful_cookie' => 'laravel_sanctum',
    'path'            => '/',
    'domain'          => null,
    'secure'          => false,     // ← MUST BE false for http://
    'http_only'       => true,
    'same_site'       => 'lax',

];
