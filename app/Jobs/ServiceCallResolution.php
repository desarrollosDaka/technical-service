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
        
    }
}
