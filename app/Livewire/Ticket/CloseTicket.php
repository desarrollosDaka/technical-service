<?php

namespace App\Livewire\Ticket;

use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class CloseTicket extends Component
{
    /**
     * Close the ticket
     *
     * @return void
     */
    public function close(): void
    {
        Cache::delete('service_call_for:' . request()->ip());
        redirect()->route('index');
    }

    /**
     * Render
     *
     * @return void
     */
    public function render()
    {
        return <<<'BLADE'
            <x-button black light label="{{ __('Cerrar') }}" spinner wire:click="close" />
        BLADE;
    }
}
