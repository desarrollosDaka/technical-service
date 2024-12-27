<?php

namespace App\Console\Commands\Ticket;

use App\Models\Ticket;
use Illuminate\Console\Command;
use App\Enums\Ticket\Status as TicketStatus;

/**
 * Los tickets que estén "Resolution" con se cierra en un lapso de 48 hrs si el usuario no califica
 */
class CloseAutomaticTicket extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:close-automatic-ticket';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Los tickets que estén "Resolution" con se cierra en un lapso de 48 hrs si el usuario no califica';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Ticket::where('status', TicketStatus::Resolution)
            ->doesntHave('qualify')
            ->where('updated_at', '<', now()->subHour(48))
            ->get()
            ->each(function (Ticket $ticket) {
                $ticket->update([
                    'status' => TicketStatus::Close,
                ]);
            });
    }
}
