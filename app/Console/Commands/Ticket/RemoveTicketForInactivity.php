<?php

namespace App\Console\Commands\Ticket;

use App\Enums\Ticket\Status;
use App\Models\Ticket;
use Illuminate\Console\Command;
use App\Enums\Ticket\Status as TicketStatus;

class RemoveTicketForInactivity extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:remove-ticket-for-inactivity';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cancela el ticket de forma automática después de 72 horas de inactividad por parte en la primera visita (no pautada).';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Ticket::where('status', TicketStatus::Open)
            ->doesntHave('visits')
            ->where('created_at', '<', now()->subHour(72))
            ->get()
            ->each(function (Ticket $ticket) {
                $ticket->update([
                    'status' => TicketStatus::Cancel,
                ]);

                $ticket->serviceCall()->update([
                    'app_status' => TicketStatus::Cancel,
                    'ASSIGNED_TECHNICIAN' => null,
                ]);
            });
    }
}
