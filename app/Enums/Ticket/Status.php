<?php

namespace App\Enums\Ticket;

enum Status: int
{
    case Open = 1;
    case Close = 2;
    case Reject = 3; # Cuando el técnico rechaza el ticket
    case Progress = 4; # Cuando el técnico esta trabajando en el ticket
    case inPause = 5;

    public function getLabel(): string
    {
        return __("ticket.status.{$this->value}");
    }

    public function getColor(): string
    {
        return match ($this->value) {
            self::Open->value => 'secondary',
            self::Close->value => 'black',
            self::Reject->value => 'negative',
            self::Progress->value => 'primary',
            self::inPause->value => 'warning',
        };
    }
}
