<?php

namespace App\Livewire\Ticket;

use App\Enums\Ticket\Status;
use App\Models\Ticket;
use Livewire\Component;
use App\Models\QualifySupport;
use App\Models\Tabulator;
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
    public array $services = [];

    /**
     * Listado de visitas
     */
    public array $confirmed_services = [];

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
        Ticket::current()->visits->each(function (TechnicalVisit $visit) {
            foreach ($visit->services ?? [] as $service) {
                $findTabulator = Tabulator::where('n', (string) $service)->first();
                if ($findTabulator) {
                    $previousService = $this->previousQualify ? $this->previousQualify->meta['confirmed_services'] : [];
                    $has = true;

                    if (isset($previousService[$findTabulator->n])) {
                        $has = $previousService[$findTabulator->n];
                    }

                    $this->services[$findTabulator->n] = $findTabulator->toArray();
                    $this->confirmed_services[$findTabulator->n] = $has;
                }
            }
        });
    }

    /**
     * Send
     *
     * @return void
     */
    public function send()
    {
        $this->validate();
        $confirmed_services = [];

        foreach ($this->confirmed_services as $key => $value) {
            $confirmed_services[] = [
                'service_n' => $key,
                'confirmed' => $value
            ];
        }

        $this->previousQualify = QualifySupport::create([
            'qualification' => $this->star,
            'comment' => $this->comment,
            'ticket_id' => Ticket::current()->getKey(),
            'meta' => [
                'confirmed_services' => $this->confirmed_services,
            ],
        ]);

        Ticket::current()->update(['status' => Status::Close]);

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
