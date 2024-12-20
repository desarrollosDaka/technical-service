<?php

namespace App\Livewire\Ticket;

use App\Models\Ticket;
use Livewire\Component;
use App\Models\QualifySupport;
use App\Models\TechnicalVisit;

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
     * Visitas
     *
     * @var array
     */
    public array $visits = [];

    public array $visits_occurred = [];

    /**
     * Mount
     *
     * @return void
     */
    public function mount(): void
    {
        validateTicketAndServiceCall();
        $this->previousQualify = Ticket::current()->qualify;

        $this->star = $this->previousQualify ? $this->previousQualify->qualification : 0;
        $this->comment = $this->previousQualify ? $this->previousQualify->comment : '';
        $this->visits = array_map(fn(array $visit) => [...$visit, 'has' => true], Ticket::current()->visits->toArray());

        foreach ($this->visits as  $value) {
            $this->visits_occurred[$value['id']] = $value['has'];
        }
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
            'meta' => [
                'visits_occurred_id' => $this->visits_occurred
            ],
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
