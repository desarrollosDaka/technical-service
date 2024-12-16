<?php

namespace App\Jobs;

use App\Enums\PartRequest\Status as PartRequestStatus;
use App\Models\PartRequest;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class UpdatePartRequest implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public array $partRequests
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach ($this->partRequests as $partRequest) {
            $partRequestFind = PartRequest::find($partRequest['id']);

            if ($partRequestFind) {
                $partRequestFind->update([
                    ...$partRequest,
                    'meta' => [
                        'reject_date' => $partRequest['status'] === PartRequestStatus::Rejected->value ? now() : null,
                        'approved_date' => $partRequest['status'] === PartRequestStatus::Approved->value ? now() : null,
                        ...json_decode($partRequest['meta'] ?? "[]", true),
                    ],
                ]);
            }
        }
    }
}
