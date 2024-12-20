<?php

namespace App\Enums\PartRequest;

enum Status: int
{
    case New = 1;
    case Approved = 2;
    case Rejected = 3;
    case Handed = 4; # Entregado
    case MustBuyTechnical = 5; # Significa que DAKA indica que el técnico de bebe comprar el repuesto
    case UpdatedBudgetAmount = 6; # Significa que el técnico ha colocado un nuevo presupuesto y este debe ser aprobado
    case ApprovedBudgetAmount = 7; # Significa que DAKA a aprobado del presupuesto
    case AlreadyBoughtPart = 8; # Significa que el técnico ya ha comprado el repuesto


    public function getLabel(): string
    {
        return __("part-request.status.{$this->value}");
    }
}
