<?php

namespace App\Enums\PartRequest;

enum Status: int
{
    case New = 1;
    case Approved = 2;
    case Rejected = 3;
    case Handed = 4; # Entregado
    case BuyTechnical = 5; # Comprado por el técnico


    public function getLabel(): string
    {
        return __("part-request.status.{$this->value}");
    }
}
