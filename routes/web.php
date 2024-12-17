<?php

use App\Http\Middleware\CurrentServiceCall;
use App\Http\Middleware\WithoutServiceCall;
use App\Models\Product;
use App\Models\ServiceCall;
use App\Models\Tabulator;
use App\Models\Technical;
use App\Models\Ticket;
use Illuminate\Support\Facades\Route;

Route::view('/', 'pages.index')
    ->name('index')
    ->middleware(WithoutServiceCall::class);

Route::view('/show-ticket', 'pages.ticket.show')
    ->name('ticket.show')
    ->middleware(CurrentServiceCall::class);

Route::get('/technical', function () {
    if (app()->hasDebugModeEnabled()) {
        return Technical::orderBy('id', 'DESC')->limit(50)->get();
    }
    return 'Oops!';
});

Route::get('/service-calls', function () {
    if (app()->hasDebugModeEnabled()) {
        return ServiceCall::orderBy('id', 'DESC')->limit(50)->get();
    }
    return 'Oops!';
});

Route::get('/tickets', function () {
    if (app()->hasDebugModeEnabled()) {
        return Ticket::orderBy('id', 'DESC')->limit(50)->get();
    }
    return 'Oops!';
});

Route::get('/products', function () {
    if (app()->hasDebugModeEnabled()) {
        return Product::orderBy('id', 'DESC')->limit(50)->get();
    }
    return 'Oops!';
});

Route::get('/tabulators', function () {
    if (app()->hasDebugModeEnabled()) {
        return Tabulator::orderBy('id', 'DESC')->limit(50)->get();
    }
    return 'Oops!';
});
