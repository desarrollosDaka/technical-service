<?php

namespace App\Jobs;

use App\Enums\ServiceCall\Status as ServiceCallStatus;
use App\Models\ServiceCall;
use App\Models\Ticket;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

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
            $serviceCall = ServiceCall::where('callID', $insert['callID'])->first();

            if (!$serviceCall) {
                continue;
            }

            Ticket::create([
                'service_call_id' => $serviceCall->getKey(),
                'customer_name' => $insert['custmrName'],
                'technical_id' => '', // TODO: Asignar tecnico
            ]);

            $serviceCall->update([
                'app_status' => ServiceCallStatus::InProgress,
            ]);
        }
    }
}
