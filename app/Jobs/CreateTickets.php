<?php

namespace App\Jobs;

use App\Enums\Ticket\Status as TicketStatus;
use App\Models\ServiceCall;
use App\Models\Technical;
use App\Models\Ticket;
use Berkayk\OneSignal\OneSignalFacade;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class CreateTickets implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public array $inserts
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach ($this->inserts as $insert) {
            $key = 'callID';

            try {
                if (is_string($insert)) {
                    [$explodeKey, $explodeInsert] = explode(':', $insert);
                    $key = $explodeKey;
                    $insert = $explodeInsert;
                }
            } catch (\Throwable $th) {
                Log::info('No se pudo obtener el ID de la llamada de servicio', [
                    $key => $insert,
                ]);
                continue;
            }
            // Hacer el split para contractos y callid
            $serviceCall = ServiceCall::where($key, $insert)->first();

            if (!$serviceCall) {
                continue;
            }

            $technical = Technical::where('ID_user', $serviceCall->ASSIGNED_TECHNICIAN)
                ->first();

            if (!$technical) {
                Log::error('No se encontró el técnico en la llamada de servicio', [
                    'callID' => $insert,
                    'ASSIGNED_TECHNICIAN' => $serviceCall->ASSIGNED_TECHNICIAN,
                ]);
                continue;
            }

            $ticketCreated = Ticket::create([
                'title' => Arr::get($serviceCall, 'itemName', $serviceCall->subject),
                'service_call_id' => $serviceCall->getKey(),
                'customer_name' => $serviceCall->custmrName,
                'technical_id' => $technical->getKey(),
                'status' => TicketStatus::Progress,
            ]);

            $serviceCall->update([
                'app_status' => TicketStatus::Progress,
            ]);

            $heading = [
                'es' => 'Servicio técnico Daka',
                'en' => 'Daka technical service',
            ];

            $content = [
                'es' => "Hola! {$technical->User_name} Tienes una nueva asignación de ticket",
                'en' => "Hello! {$technical->User_name} You have a new ticket assignment",
            ];

            // Configurar la notificación para enviar a alias specific
            $fields = [
                'filters' => [
                    [
                        "field" => "tag",
                        "key" => "external_id",
                        "relation" => "=",
                        "value" => "technical-{$technical->getKey()}"
                    ],
                ],
                'contents' => $content,
                'headings' => $heading,
                'data' => [
                    'ticket_id' => $ticketCreated->getKey(),
                ],
            ];

            OneSignalFacade::sendNotificationCustom($fields);
        }
    }
}
