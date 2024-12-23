<?php

use App\Console\Commands\Ticket\RemoveTicketForInactivity;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::command(RemoveTicketForInactivity::class)->hourly();
