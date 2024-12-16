<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BackendToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->get('token', '-') !== config('api.b_b_token', 'WbfJx49izylMYXIOP6fqpVcNjYbwwJJanXF1')) {
            abort(Response::HTTP_BAD_REQUEST, __('El token de autenticación no es valido'));
        }
        return $next($request);
    }
}
