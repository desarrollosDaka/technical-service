<?php

namespace App\Console\Commands\Ticket;

use Illuminate\Console\Command;

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
        //
    }
}
