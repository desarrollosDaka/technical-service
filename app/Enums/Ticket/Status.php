<?php

namespace App\Enums\Ticket;

enum Status: int
{
    case Open = 1;
    case Close = 2;
    case Reject = 3; # Cuando el técnico rechaza el ticket
}
