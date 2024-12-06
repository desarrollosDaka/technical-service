<?php

namespace App\Enums\ServiceCall;

enum Status: int
{
    case Open = 1;
    case Close = 2;
    case Reject = 3; # Cuando el técnico rechaza el ticket
    case Progress = 4; # Cuando el técnico esta trabajando en el ticket
    case Blocked = 5;
}
