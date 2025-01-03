<?php

namespace App\Jobs;

use App\Enums\PartRequest\Status as PartRequestStatus;
use App\Models\PartRequest;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Berkayk\OneSignal\OneSignalFacade;

/**
 * Enviar notificación al técnico de un cambio de estatus en la solicitud de repuesto
 */
class PartRequestChangeStatusNotification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public PartRequest $partRequest
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if (in_array(
            $this->partRequest->status->value,
            [PartRequestStatus::New->value, PartRequestStatus::UpdatedBudgetAmount->value, PartRequestStatus::AlreadyBoughtPart->value]
        )) {
            return;
        }

        $ticket = $this->partRequest->ticket()->select(['tickets.id', 'tickets.technical_id'])->first();
        $technical = $ticket->technical;

        $heading = [
            'es' => 'Servicio técnico Daka',
            'en' => 'Daka technical service',
        ];

        $content = [
            'es' => "Hola! {$technical->User_name} su solicitud de repuesto: {$this->partRequest->name}, tiene una nueva actualización",
            'en' => "Hello! {$technical->User_name} your replacement application: {$this->partRequest->name}, has a new update",
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
                'ticket_id' => $ticket->getKey(),
                'part_request_id' => $this->partRequest->getKey(),
            ],
        ];

        if (config('api.one_signal_notifications', true)) {
            try {
                OneSignalFacade::sendNotificationCustom($fields);
            } catch (\Throwable $th) {
                //throw $th;
            }
        }
    }
}
