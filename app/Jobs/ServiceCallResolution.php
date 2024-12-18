<?php

namespace App\Jobs;

use App\Models\ServiceCall;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Enums\Ticket\Status as TicketStatus;

class ServiceCallResolution implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public ServiceCall $serviceCall
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $ticket = $this->serviceCall->tickets()->orderByDesc('id')->first();
        $visits = $ticket->visits;
        $technical = $ticket->technical;

        $resolutionString = '### Estado: ' . $this->serviceCall->app_status->getLabel() . " =ID= " . $this->serviceCall->callID . "\n\n";

        // Detalles del cliente
        $resolutionString .= "## Cliente: " . $this->serviceCall->custmrName . "\n";
        $resolutionString .= "# Dirección: " . $this->serviceCall->Location . "\n";
        $resolutionString .= "# Coordenadas: " . $this->serviceCall->latitude . ":" . $this->serviceCall->longitude . "\n\n";

        // Detalles del técnico
        $resolutionString .= "## Técnico: " . $technical->User_name . " =ID= " . $technical->ID_user;
        $resolutionString .= "# Teléfono: " . $technical->Phone . "\n";
        $resolutionString .= "# Comercial: " . $technical->Name_user_comercial . "\n";
        $resolutionString .= "# Email: " . $technical->Email . "\n";
        $resolutionString .= "# Dirección: " . $technical->Address . "\n";

        // Detalles del ticket
        $resolutionString .= "## Detalles del Ticket (Aplicativo)\n";
        $resolutionString .= "# ID: " . $ticket->id . " =Titulo= " . $ticket->title . "\n";
        $resolutionString .= "# Aceptado el: " . $ticket->created_at->format('d/m/Y') . "\n";
        $resolutionString .= "# Técnico:  " . $ticket->technical->name . " : " . $ticket->technical->email . " =ID= " . $ticket->technical_id . "\n";

        if ($ticket->diagnosis_date && $ticket->status === TicketStatus::Progress) {
            $resolutionString .= "# Diagnostico: " . $ticket->diagnosis_date?->format('d/m/Y') . " =Detalles=" . $ticket->diagnosis_detail;
        } else if ($ticket->reject_date && $ticket->status === TicketStatus::Reject) {
            $resolutionString .= "# Rechazado: " . $ticket->reject_date?->format('d/m/Y') . " =Detalles=" . $ticket->reject_detail;
        } else if ($ticket->solution_date && ($ticket->status === TicketStatus::Resolution || $ticket->status === TicketStatus::Close)) {
            $resolutionString .= "# Resolución Final: " . $ticket->solution_date?->format('d/m/Y') . " =Detalles=" . $ticket->solution_detail;
        }

        // Listado de visitas
        $resolutionString .= "\n\n## Detalles de las visitas\n";

        if (count($visits) < 1) {
            $resolutionString .= "\n# Todavía no se han pautados visitas";
        }

        foreach ($visits as $visit) {
            $resolutionString .= "\n# Visita:" . $visit->id . " =Creada el= " . $visit->created_at->format('d/m/Y');
            $resolutionString .= "\n#Fecha pautada de la visita:" . $ticket->visit_date->format('d/m/Y H:i:s');
            $resolutionString .= "\n#Observaciones el técnico:" . $ticket->observations;

            // Ha sufrido reprogramaciones
            if (count($visit->reprogramming) === 0) {
                $resolutionString .= "\n# No ha sufrido reprogramaciones";
            } else {
                $resolutionString .= "\n# La visita se ha reprogramado, a continuación el detalle de las reprogramaciones...";
                foreach ($visit->reprogramming as $reason => $reprogramming) {
                }
            }
        }

        $resolutionString .= "\n\n### Resumen final\n";
    }
}
