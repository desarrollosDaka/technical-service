<?php

namespace App\Observers;

use App\Enums\Ticket\Status as TicketStatus;
use App\Jobs\ServiceCallResolution;
use App\Models\Ticket;

class TicketObserver
{
    /**
     * Handle the Ticket "created" event.
     */
    public function created(Ticket $ticket): void
    {
        //
    }

    /**
     * Handle the Ticket "updated" event.
     */
    public function updated(Ticket $ticket): void
    {
        $serviceCall = $ticket->serviceCall;
        $update['app_status'] = $ticket->status;

        if ($ticket->status === TicketStatus::Reject) {
            $update['ASSIGNED_TECHNICIAN'] = null;
        }

        $serviceCall->update($update);
        ServiceCallResolution::dispatch($serviceCall);
    }

    /**
     * Handle the Ticket "deleted" event.
     */
    public function deleted(Ticket $ticket): void
    {
        //
    }

    /**
     * Handle the Ticket "restored" event.
     */
    public function restored(Ticket $ticket): void
    {
        //
    }

    /**
     * Handle the Ticket "force deleted" event.
     */
    public function forceDeleted(Ticket $ticket): void
    {
        //
    }
}