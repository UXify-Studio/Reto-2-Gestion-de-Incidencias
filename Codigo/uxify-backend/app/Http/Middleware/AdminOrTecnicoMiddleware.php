<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminOrTecnicoMiddleware {
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $rol = Auth::user()->id_rol;
            if ($rol == 1 || $rol == 2) {
                return $next($request);
            } else {
                return response()->json(['message' => 'Forbidden: You do not have the required role.'], 403);
            }
        } else {
            return response()->json(['message' => 'Unauthorized: You are not authenticated.'], 401);
        }
    }
}
