<?php

namespace App\Livewire\Ticket;

use App\Models\Ticket;
use Livewire\Component;
use App\Models\QualifySupport;

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
     * Calificación previa
     *
     * @var Qualify|null
     */
    public ?QualifySupport $previousQualify = null;

    /**
     * Mount
     *
     * @return void
     */
    public function mount(): void
    {
        $this->previousQualify = Ticket::current()->qualify;

        $this->star = $this->previousQualify ? $this->previousQualify->qualification : 0;
        $this->comment = $this->previousQualify ? $this->previousQualify->comment : '';
    }

    /**
     * Send
     *
     * @return void
     */
    public function send()
    {
        $this->previousQualify = QualifySupport::create([
            'qualification' => $this->star,
            'comment' => $this->comment,
            'ticket_id' => Ticket::current()->getKey(),
        ]);

        $this->dispatch('closeModal', 'qualification');
    }

    /**
     * Render
     */
    public function render()
    {
        return view('livewire.ticket.qualify');
    }
}
