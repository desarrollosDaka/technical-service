<?php

namespace App\Enums\Visit;

enum Reason: int
{
    case ClientCant = 1;
    case TechnicalCant = 2;
    case Other = 3;

    public function getLabel(): string
    {
        return __("visit.reprogramming-reason.{$this->value}");
    }

    /**
     * Obtener opciones para un select
     *
     * @return array
     */
    public static function getOptions(): array
    {
        $reasons = [];

        for ($i = 1; $i <= 3; $i++) {
            $reasons[$i] = __("visit.reprogramming-reason.{$i}");
        }

        return $reasons;
    }
}
