<?php

namespace App\Enums\Ticket;

enum Status: int
{
    case Open = 1;
    case Close = 2; # Cuando el cliente le da calificado al ticket (COMPLETADO)
    case Reject = 3; # Cuando el técnico rechaza el ticket
    case Progress = 4; # Cuando el técnico esta trabajando en el ticket
    case inPause = 5;
    case Cancel = 6; # Cuando se cancela totalmente
    case Resolution = 7; # Estatus cuando el técnico resuelve el ticket

    public function getLabel(): string
    {
        return __("ticket.status.{$this->value}");
    }

    /**
     * Color?
     *
     * @return string
     */
    public function getColor(): string
    {
        return match ($this->value) {
            self::Open->value => 'secondary',
            self::Close->value => 'primary',
            self::Reject->value => 'negative',
            self::Progress->value => 'primary',
            self::inPause->value => 'warning',
            self::Cancel->value => 'negative',
            self::Resolution->value => 'positive',
        };
    }
}
