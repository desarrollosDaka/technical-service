<?php

namespace App\Enums\PartRequest;

enum Status: int
{
    case New = 1;
    case Approved = 2;
    case Rejected = 3;
    case Handed = 4;
}
