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
    $visits = $ticket->visits;

    $resolutionString = '### Estado: ' . $serviceCall->app_status->getLabel() . " =ID= " . $serviceCall->callID . "\n\n";

    // Detalles del cliente
    $resolutionString .= "## Cliente: " . $serviceCall->custmrName . "\n";
    $resolutionString .= "# Dirección: " . $serviceCall->Location . "\n";
    $resolutionString .= "# Coordenadas: " . $serviceCall->latitude . ":" . $serviceCall->longitude . "\n\n";

    // Detalles del técnico
    $resolutionString .= "## Técnico: " . $serviceCall->User_name . " =ID= " . $serviceCall->ID_user;
    $resolutionString .= "# Teléfono: " . $serviceCall->Phone . "\n";
    $resolutionString .= "# Comercial: " . $serviceCall->Name_user_comercial . "\n";
    $resolutionString .= "# Email: " . $serviceCall->Email . "\n";
    $resolutionString .= "# Dirección: " . $serviceCall->Address . "\n";

    // Detalles del ticket
    $resolutionString .= "## Detalles del Ticket (Aplicativo)\n";
    $resolutionString .= "# ID: " . $ticket->id . " =Titulo= " . $ticket->title . "\n";
    $resolutionString .= "# Aceptado el: " . $ticket->created_at->format('d/m/Y') . "\n";
    $resolutionString .= "# Técnico:  " . $ticket->technical->name . " : " . $ticket->technical->email . " =ID= " . $ticket->technical_id . "\n";

    if ($ticket->diagnosis_date && $ticket->status === TicketStatus::Progress) {
        $resolutionString .= "# Diagnostico: " . $ticket->diagnosis_date?->format('d/m/Y') . " =Detalles=" . $ticket->diagnosis_detail;
    } else if ($ticket->reject_date && $ticket->status === TicketStatus::Reject) {
        $resolutionString .= "# Rechazado: " . $ticket->reject_date?->format('d/m/Y') . " =Detalles=" . $ticket->reject_detail;
    } else if ($ticket->solution_date && ($ticket->status === TicketStatus::Resolution || $ticket->status === TicketStatus::Close)) {
        $resolutionString .= "# Resolución Final: " . $ticket->solution_date?->format('d/m/Y') . " =Detalles=" . $ticket->solution_detail;
    }

    // Listado de visitas
    $resolutionString .= "\n\n## Detalles de las visitas\n";

    if (count($visits) < 1) {
        $resolutionString .= "\n# Todavía no se han pautados visitas";
    }

    foreach ($visits as $visit) {
        $resolutionString .= "\n# Visita:" . $visit->id . " =Creada el= " . $visit->created_at->format('d/m/Y');
        $resolutionString .= "\n#Fecha pautada de la visita:" . $ticket->visit_date->format('d/m/Y H:i:s');
        $resolutionString .= "\n#Observaciones el técnico:" . $ticket->observations;

        // Ha sufrido reprogramaciones
        if (count($visit->reprogramming) === 0) {
            $resolutionString .= "\n# No ha sufrido reprogramaciones";
        } else {
            $resolutionString .= "\n# La visita se ha reprogramado, a continuación el detalle de las reprogramaciones...";
            foreach ($visit->reprogramming as $reason => $reprogramming) {
            }
        }
    }

    $resolutionString .= "\n\n### Resumen final\n";

    return $resolutionString;
});
