<?php

use App\Enums\Ticket\Status as TicketStatus;
use App\Http\Middleware\CurrentServiceCall;
use App\Http\Middleware\WithoutServiceCall;
use App\Models\Product;
use App\Models\ServiceCall;
use App\Models\Tabulator;
use App\Models\Technical;
use App\Models\Ticket;
use Berkayk\OneSignal\OneSignalFacade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

Route::view('/', 'pages.index')
    ->name('index')
    ->middleware(WithoutServiceCall::class);

Route::get('/login', function (Request $request) {
    return response(
        ['message' => 'Unauthenticated.'],
        Response::HTTP_UNAUTHORIZED
    );
})->name('login');

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
        return ServiceCall::orderBy('id', 'DESC')
            ->orderByDesc('updated_at')
            ->limit(50)
            ->get();
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


Route::get('/test-one-signal', function (Request $request) {
    if (!app()->hasDebugModeEnabled()) {
        return 'Opps!';
    }

    $request->validate([
        'ticket_id' => 'required',
        'technical_id' => 'required',
    ]);

    $heading = [
        'es' => 'Servicio técnico Daka',
        'en' => 'Daka technical service',
    ];

    $content = [
        'es' => "Hola! ESTO ES UN TEST",
        'en' => "Hola! ESTO ES UN TEST",
    ];

    $fields = [
        'filters' => [
            [
                "field" => "tag",
                "key" => "external_id",
                "relation" => "=",
                "value" => "technical-{$request->get('technical_id', 0)}"
            ],
        ],
        'contents' => $content,
        'headings' => $heading,
        'data' => [
            'ticket_id' => $request->get('ticket_id', 0),
        ],
    ];

    try {
        OneSignalFacade::sendNotificationCustom($fields);
        return 'OneSignalFacade Send';
    } catch (\Throwable $th) {
        dump($th);
    }

    return 'OneSignalFacade Falla';
});
