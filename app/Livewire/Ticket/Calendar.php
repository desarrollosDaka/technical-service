<?php

namespace App\Livewire\Ticket;

use App\Models\TechnicalVisit;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Livewire\Component;

class Calendar extends Component
{
    /**
     * Listado de visitas
     *
     * @var Collection
     */
    public Collection $visits;

    /**
     * Render
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.ticket.calendar');
    }
}
