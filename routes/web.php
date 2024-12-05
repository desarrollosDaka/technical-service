<?php

use App\Models\ServiceCall;
use App\Models\Technical;
use Illuminate\Support\Facades\Route;

Route::view('/', 'pages.index');

Route::get('/technical', function () {
    if (app()->hasDebugModeEnabled()) {
        return Technical::all();
    }
    return 'Oops!';
});

Route::get('/service-calls', function () {
    if (app()->hasDebugModeEnabled()) {
        return ServiceCall::latest()->limit(15)->get();
    }
    return 'Oops!';
});
