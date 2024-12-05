<?php

namespace App\Enums\ServiceCall;

enum Status: int
{
    case New = 1;
    case InProgress = 2;
    case Finish = 3;
}
