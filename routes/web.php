<?php

use App\Http\Middleware\CurrentServiceCall;
use App\Http\Middleware\WithoutServiceCall;
use App\Models\ServiceCall;
use App\Models\Technical;
use Illuminate\Support\Facades\Route;

Route::view('/', 'pages.index')
    ->name('index')
    ->middleware(WithoutServiceCall::class);
Route::view('/show-ticket', 'pages.ticket.show')
    ->name('ticket.show')
    ->middleware(CurrentServiceCall::class);

Route::get('/technical', function () {
    if (app()->hasDebugModeEnabled()) {
        return Technical::latest()->limit(50)->get();
    }
    return 'Oops!';
});

Route::get('/service-calls', function () {
    if (app()->hasDebugModeEnabled()) {
        return ServiceCall::latest()->limit(50)->get();
    }
    return 'Oops!';
});
