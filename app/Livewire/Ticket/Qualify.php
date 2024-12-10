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
     * Comentarios adicionales
     *
     * @var string
     */
    public string $comment = '';

    /**
     * Send
     *
     * @return void
     */
    public function send()
    {
        dd($this->star, $this->comment);
    }

    public function render()
    {
        return view('livewire.ticket.qualify');
    }
}
