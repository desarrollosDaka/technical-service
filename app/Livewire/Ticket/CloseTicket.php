<?php

namespace App\Livewire\Ticket;

use App\Models\ServiceCall;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class CloseTicket extends Component
{
    /**
     * btn text
     *
     * @var string
     */
    public string $btnText = 'Cerrar';

    /**
     * Color del botón
     *
     * @var string
     */
    public string $color = 'black';

    /**
     * Light btn
     *
     * @var bool
     */
    public bool $light = true;

    /**
     * Close the ticket
     *
     * @return void
     */
    public function close(): void
    {
        Cache::delete(ServiceCall::idClientWeb());
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
            <x-button :$color light label="{{ __($btnText) }}" spinner wire:click="close" />
        BLADE;
    }
}
