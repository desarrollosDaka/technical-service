<?php

use App\Enums\Ticket\Status as TicketStatus;
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


Route::get('/test', function () {
    $serviceCall = ServiceCall::find(3);

    $ticket = $serviceCall->tickets()->orderByDesc('id')->first();

    $resolutionString = '### Estado: ' . $serviceCall->app_status->getLabel() . " =ID= " . $serviceCall->callID . "\n\n";
    $resolutionString .= "## Cliente: " . $serviceCall->custmrName . "\n";
    $resolutionString .= "# Dirección: " . $serviceCall->Location . "\n";
    $resolutionString .= "# Coordenadas: " . $serviceCall->latitude . ":" . $serviceCall->longitude . "\n\n";
    $resolutionString .= "## Detalles del Ticket (Aplicativo)\n";
    $resolutionString .= "# ID: " . $ticket->ID_user . " =Titulo= " . $ticket->title . "\n";
    $resolutionString .= "# Aceptado el: " . $ticket->created_at->format('d/m/Y') . "\n";
    $resolutionString .= "# Técnico:  " . $ticket->technical->name . " : " . $ticket->technical->email . " =ID= " . $ticket->technical_id . "\n";

    if ($ticket->diagnosis_date && $ticket->status === TicketStatus::Progress) {
        $resolutionString .= "# Diagnostico: " . $ticket->diagnosis_date?->format('d/m/Y') . " =Detalles=" . $ticket->diagnosis_detail . "\n";
    } else if ($ticket->reject_date && $ticket->status === TicketStatus::Reject) {
        $resolutionString .= "# Rechazado: " . $ticket->reject_date?->format('d/m/Y') . " =Detalles=" . $ticket->reject_detail . "\n";
    } else if ($ticket->solution_date && ($ticket->status === TicketStatus::Resolution || $ticket->status === TicketStatus::Close)) {
        $resolutionString .= "# Resolución Final: " . $ticket->solution_date?->format('d/m/Y') . " =Detalles=" . $ticket->solution_detail . "\n";
    }

    return $resolutionString;
});
