<?php

namespace App\Livewire\Ticket;

use Livewire\Component;

class CloseTicket extends Component
{
    public function render()
    {
        return <<<'BLADE'
            <x-button black light label="{{ __('Cerrar') }}" />
        BLADE;
    }
}
