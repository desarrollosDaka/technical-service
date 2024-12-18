<?php

namespace App\Jobs;

use App\Models\ServiceCall;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

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

        $resolutionString = '### Estado: ' . $this->serviceCall->status->getLabel() . "\n\n";
        $resolutionString .= "## Detalles del Ticket (Aplicativo)\n";
        $resolutionString .= "# ID: " . $ticket->id . " : " . $ticket->title . "\n";
        $resolutionString .= "# Técnico :  " . $ticket->technical->name . " : " . $ticket->technical->email . " ID " . $ticket->technical_id;
        $resolutionString .= "# Diagnostico: " . $ticket->diagnosis_date->format('d/m/Y') . " =Detalles=" . $ticket->diagnosis_detail;
    }
}
