<?php

namespace App\Enums\ServiceCall;

enum Status: int
{
    case Open = 1;
    case Reject = 2;
    case InProgress = 3;
    case Completed = 4;
    case InPause = 5;
}
