<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user(); 

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized: Please log in'
            ], 401);
        }

        if (!$user->is_admin) {
            return response()->json([
                'success' => false,
                'message' => 'No permission: Admin access required'
            ], 403);
        }

        return $next($request);
    }
}
