<?php

namespace App\Livewire\Ticket;

use App\Models\ServiceCall;
use Livewire\Component;

class Address extends Component
{
    public string $address;

    public function mount(): void
    {
        $this->address = ServiceCall::current()->Location;
    }

    public function render()
    {
        return view('livewire.ticket.address');
    }
}
