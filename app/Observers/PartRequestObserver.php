<?php

namespace App\Observers;

use App\Jobs\PartRequestChangeStatusNotification;
use App\Jobs\ServiceCallResolution;
use App\Models\PartRequest;

class PartRequestObserver
{
    /**
     * Handle the PartRequest "created" event.
     */
    public function created(PartRequest $partRequest): void
    {
        ServiceCallResolution::dispatch(
            $partRequest->ticket()
                ->select(['tickets.id', 'tickets.service_call_id'])
                ->first()
                ->serviceCall
        );
    }

    /**
     * Handle the PartRequest "updated" event.
     */
    public function updated(PartRequest $partRequest): void
    {
        ServiceCallResolution::dispatch(
            $partRequest->ticket()
                ->select(['tickets.id', 'tickets.service_call_id'])
                ->first()
                ->serviceCall
        );

        PartRequestChangeStatusNotification::dispatch($partRequest);
    }

    /**
     * Handle the PartRequest "deleted" event.
     */
    public function deleted(PartRequest $partRequest): void
    {
        ServiceCallResolution::dispatch(
            $partRequest->ticket()
                ->select(['tickets.id', 'tickets.service_call_id'])
                ->first()
                ->serviceCall
        );
    }

    /**
     * Handle the PartRequest "restored" event.
     */
    public function restored(PartRequest $partRequest): void
    {
        //
    }

    /**
     * Handle the PartRequest "force deleted" event.
     */
    public function forceDeleted(PartRequest $partRequest): void
    {
        //
    }
}
