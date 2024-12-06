<?php

namespace App\Http\Middleware;

use App\Models\ServiceCall;
use App\Models\Ticket;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WithoutServiceCall
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (ServiceCall::current() && Ticket::current()) {
            return redirect()->route('ticket.show');
        }

        return $next($request);
    }
}
