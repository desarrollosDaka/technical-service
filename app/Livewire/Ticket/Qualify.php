<?php

namespace App\Livewire\Ticket;

use Livewire\Component;

class Qualify extends Component
{
    /**
     * Estrellas dadas
     *
     * @var integer
     */
    public int $star = 0;

    /**
     * Rating
     *
     * @param integer $star
     * @return void
     */
    public function setRating(int $star): void
    {
        $this->star = $star;
    }

    /**
     * Send
     *
     * @return void
     */
    public function send()
    {
        # code...
    }

    public function render()
    {
        return view('livewire.ticket.qualify');
    }
}
