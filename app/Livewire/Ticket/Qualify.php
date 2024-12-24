<?php

namespace App\Livewire\Ticket;

use App\Models\Ticket;
use Livewire\Component;
use App\Models\QualifySupport;
use App\Models\TechnicalVisit;
use Livewire\Attributes\Validate;

class Qualify extends Component
{
    /**
     * Estrellas dadas
     *
     * @var integer
     */
    #[Validate('required|numeric|min:1')]
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

    /**
     * Listado de visitas
     */
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
        $this->visits = array_map(
            function (array $visit) {
                $has = true;

                if ($this->previousQualify && $this->previousQualify->meta['visits']) {
                    $find = current(
                        array_filter($this->previousQualify->meta['visits'], fn($item) => $item['visit_id'] == $visit['id']) ?? ['occurred' => false]
                    );
                    $has = $find['occurred'];
                }

                return [
                    'has' => $has,
                    ...$visit,
                ];
            },
            Ticket::current()->visits->toArray()
        );

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
        $this->validate();
        $visits_occurred = [];

        foreach ($this->visits_occurred as $key => $value) {
            $visits_occurred[] = [
                'visit_id' => $key,
                'occurred' => $value
            ];
        }

        $this->previousQualify = QualifySupport::create([
            'qualification' => $this->star,
            'comment' => $this->comment,
            'ticket_id' => Ticket::current()->getKey(),
            'meta' => [
                'visits' => $visits_occurred
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
