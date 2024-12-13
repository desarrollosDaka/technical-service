<?php

namespace App\Jobs;

use App\Models\ServiceCall;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Enums\Ticket\Status as TicketStatus;
use App\Enums\Visit\Reason;
use Carbon\Carbon;

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
        $total_reprogramming = 0;

        $resolutionString = '### Estado: ' . $this->serviceCall->app_status->getLabel() . " =ID= " . $this->serviceCall->callID . "\n\n";

        // Detalles del cliente
        $resolutionString .= "## Cliente: " . $this->serviceCall->custmrName . "\n";
        $resolutionString .= "# Dirección: " . $this->serviceCall->Location . "\n";
        $resolutionString .= "# Coordenadas: " . $this->serviceCall->latitude . ":" . $this->serviceCall->longitude . "\n\n";

        // Detalles del técnico
        $resolutionString .= "## Técnico: " . $technical->User_name . " =ID= " . $technical->ID_user;
        $resolutionString .= "\n# Teléfono: " . $technical->Phone . "\n";
        $resolutionString .= "# Comercial: " . $technical->Name_user_comercial . "\n";
        $resolutionString .= "# Email: " . $technical->Email . "\n";
        $resolutionString .= "# Dirección: " . $technical->Address;

        // Detalles del ticket
        $resolutionString .= "\n\n## Detalles del Ticket (Aplicativo)\n";
        $resolutionString .= "# ID: " . $ticket->id . " =Titulo= " . $ticket->title . "\n";
        $resolutionString .= "# Aceptado el: " . $ticket->created_at->format('d/m/Y') . "\n";

        if ($ticket->diagnosis_date && $ticket->status === TicketStatus::Progress) {
            $resolutionString .= "# Diagnostico: " . $ticket->diagnosis_date?->format('d/m/Y') . " =Detalles=" . $ticket->diagnosis_detail;
        } else if ($ticket->reject_date && $ticket->status === TicketStatus::Reject) {
            $resolutionString .= "# Rechazado: " . $ticket->reject_date?->format('d/m/Y') . " =Detalles=" . $ticket->reject_detail;
        } else if ($ticket->solution_date && ($ticket->status === TicketStatus::Resolution || $ticket->status === TicketStatus::Close)) {
            $resolutionString .= "# Resolución Final: " . $ticket->solution_date?->format('d/m/Y') . " =Detalles=" . $ticket->solution_detail;
        } else if ($ticket->status === TicketStatus::Open) {
            $resolutionString .= "# El ticket esta esperando ser aceptado";
        }

        // Listado de visitas
        $resolutionString .= "\n\n## Detalles de las visitas";

        if (count($visits) < 1) {
            $resolutionString .= "\n# Todavía no se han pautados visitas...";
        }

        foreach ($visits as $visit) {
            $resolutionString .= "\n----------------------------------------";
            $resolutionString .= "\n# Visita ID: " . $visit->id . " =Creada el= " . $visit->created_at->format('d/m/Y');
            $resolutionString .= "\n# Fecha pautada de la visita: " . ($visit->visit_date ? $visit->visit_date->format('d/m/Y H:i:s') : 'No hay fecha pautada');
            $resolutionString .= "\n# Observaciones el técnico:" . $visit->observations;

            // Ha sufrido reprogramaciones
            if (count($visit->reprogramming ?? []) === 0) {
                $resolutionString .= "\n# No ha sufrido reprogramaciones";
            } else {
                $resolutionString .= "\n# La visita se ha reprogramado, a continuación el detalle de las reprogramaciones...";
                foreach ($visit->reprogramming as $reason => $reprogramming) {
                    $reasonText = match ($reason) {
                        'technical' => 'Técnico',
                        'client' => 'Cliente',
                        'other' => 'Otro motivo',
                    };
                    $resolutionString .= "\n\n# Reprogramaciones por {$reasonText}, total: " . count($reprogramming);

                    foreach ($reprogramming as $key => $reprogram) {
                        $resolutionString .= "\n\n\t# Reprogramación por {$reasonText} Nº" . $key + 1;
                        $resolutionString .= "\n\t# Fecha previa pautada: " . Carbon::parse($reprogram['old_date'])->format('d/m/Y H:i:s');
                        $resolutionString .= "\n\t# Nueva fecha de pautada: " . Carbon::parse($reprogram['new_date'])->format('d/m/Y H:i:s');
                        $resolutionString .= "\n\t# Razones adicionales: " . $reprogram['extend_reason'];

                        $total_reprogramming++;
                    }
                }
            }

            // Solicitud de repuesto
            $resolutionString .= "\n-------------------------------------";
        }

        $date_compare_to = match ($ticket->status->value) {
            TicketStatus::Reject->value => $ticket->reject_date,
            TicketStatus::Close->value, TicketStatus::Resolution->value => $ticket->solution_date,
            default => null,
        };

        $resolutionString .= "\n\n### Resumen final\n";
        $resolutionString .= "\n# Total de visitas pautadas: " . count($visits);
        $resolutionString .= "\n# Total de reprogramaciones: " . $total_reprogramming;
        $resolutionString .= "\n# Duración total del ticket: " . ($date_compare_to ? $date_compare_to->diff($ticket->created_at) : 'Ticket aun abierto');

        $this->serviceCall->update([
            'resolution' => $resolutionString
        ]);
    }
}
