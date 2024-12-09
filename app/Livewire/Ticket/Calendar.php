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

    public function events(): Collection
    {
        return Ticket::current()
            ->visits()
            ->orderBy('visit_date', 'asc')
            ->get()
            ->map(function (TechnicalVisit $visit) {
                return [
                    'id' => $visit->id,
                    'title' => $visit->title,
                    'description' => $visit->observations,
                    'date' => $visit->visit_date->toDateTimeString(),
                ];
            });
    }
}
