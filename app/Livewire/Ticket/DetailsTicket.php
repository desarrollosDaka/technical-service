<?php

namespace App\Livewire\Ticket;

use App\Models\Ticket;
use Illuminate\Support\Collection;
use Livewire\Component;

class DetailsTicket extends Component
{
    public string $selectedTab = 'details';

    /**
     * Button
     *
     * @var array
     */
    public array $buttons = [
        'details' => 'Detalles del ticket',
        'visits' => 'Listado de visitas',
        'comments' => 'Comentarios',
    ];

    /**
     * Listado de visitas
     *
     * @var Collection
     */
    public Collection $visits;

    /**
     * Establecer el tab
     *
     * @param string $tab
     * @return void
     */
    public function setTab(string $tab): void
    {
        $this->selectedTab = $tab;
    }

    public function mount(): void
    {
        $this->visits = Ticket::current()
            ->visits()
            ->orderBy('visit_date', 'DESC')
            ->get();
    }

    /**
     * Render
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render(): \Illuminate\Contracts\View\View
    {
        return view('livewire.ticket.details');
    }
}
