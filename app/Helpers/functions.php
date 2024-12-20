<?php

use App\Models\ServiceCall;
use App\Models\Ticket;

/**
 * Llamada de servicio actual
 *
 * @return ServiceCall|null
 */
function serviceCall(): ?ServiceCall
{
    return ServiceCall::current();
}

if (!function_exists('ticket')) {
    /**
     * Ticket actual
     *
     * @return Ticket|null
     */
    function ticket(): ?Ticket
    {
        return Ticket::current();
    }
}


function validateTicketAndServiceCall()
{
    if (!serviceCall() || !ticket()) {
        return redirect()->route('index');
    }
}
