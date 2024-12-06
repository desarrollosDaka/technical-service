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

/**
 * Ticket actual
 *
 * @return Ticket|null
 */
function ticket(): ?Ticket
{
    return Ticket::current();
}
