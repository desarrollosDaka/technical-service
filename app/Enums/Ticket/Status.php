<?php

namespace App\Enums\Ticket;

enum Status: int
{
    case New = 1;
    case Close = 2;
    case Reject = 3; # Cuando el técnico rechaza el ticket
    case Progress = 4; # Cuando el técnico esta trabajando en el ticket
    case Blocked = 5;
}
