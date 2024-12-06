<?php

namespace App\Http\Middleware;

use App\Models\ServiceCall;
use App\Models\Ticket;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Verificar que exista un service call asociada a la IP actual
 */
class CurrentServiceCall
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!ServiceCall::current() || !Ticket::current()) {
            return redirect()->route('index');
        }

        return $next($request);
    }
}
