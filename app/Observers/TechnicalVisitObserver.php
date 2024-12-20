<?php

namespace App\Observers;

use App\Jobs\ServiceCallResolution;
use App\Models\TechnicalVisit;

class TechnicalVisitObserver
{
    /**
     * Handle the TechnicalVisit "created" event.
     */
    public function created(TechnicalVisit $technicalVisit): void
    {
        ServiceCallResolution::dispatch($technicalVisit->ticket->serviceCall);
    }

    /**
     * Handle the TechnicalVisit "updated" event.
     */
    public function updated(TechnicalVisit $technicalVisit): void
    {
        ServiceCallResolution::dispatch($technicalVisit->ticket->serviceCall);
    }

    /**
     * Handle the TechnicalVisit "deleted" event.
     */
    public function deleted(TechnicalVisit $technicalVisit): void
    {
        ServiceCallResolution::dispatch($technicalVisit->ticket->serviceCall);
    }

    /**
     * Handle the TechnicalVisit "restored" event.
     */
    public function restored(TechnicalVisit $technicalVisit): void
    {
        //
    }

    /**
     * Handle the TechnicalVisit "force deleted" event.
     */
    public function forceDeleted(TechnicalVisit $technicalVisit): void
    {
        //
    }
}
