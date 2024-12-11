<?php

namespace App\Console\Commands\Mail;

use App\Mail\TestGmail as MailTestGmail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestGmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-gmail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Realiza una prueba en gmail';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Mail::to('c.maggio@tiendasdaka.com')
            ->cc('techservices@tiendasdaka.com')
            ->bcc('techservices@tiendasdaka.com')
            ->send(new MailTestGmail());
    }
}
