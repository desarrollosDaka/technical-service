<?php

namespace App\Enums\Visit;

enum Reason: int
{
    case ClientCant = 1;
    case TechnicalCant = 2;
    case Other = 3;
}
