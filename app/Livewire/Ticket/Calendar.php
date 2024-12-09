<?php

namespace App\Livewire\Ticket;

use App\Models\TechnicalVisit;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Omnia\LivewireCalendar\LivewireCalendar;

class Calendar extends LivewireCalendar
{
    /**
     * Listado de visitas
     *
     * @var Collection
     */
    public Collection $visits;

    public function events(): Collection
    {
        return Ticket::current()->visits->map(function (TechnicalVisit $visit) {
            return [
                'id' => $visit->id,
                'title' => $visit->title,
                'description' => $visit->observations,
                'date' => $visit->visit_date->toDateTimeString(),
            ];
        });
    }
}
