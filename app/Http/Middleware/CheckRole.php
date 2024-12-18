<?php

namespace Code\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        if (!auth()->check()) {
            abort(403, 'Usuario no autenticado.');
        }
        $user = auth()->user();
        if ($user->role !== $role) {
            abort(403, 'No tienes permisos para acceder a esta página.');
        }
        return $next($request);
    }
}
