<?php

use App\Models\ServiceCall;
use App\Models\Technical;
use Illuminate\Support\Facades\Route;

Route::view('/', 'pages.index');

Route::get('/technical', function () {
    if (app()->environment('local')) {
        return Technical::all();
    }
    return 'Oops!';
});

Route::get('/service-calls', function () {
    if (app()->environment('local')) {
        return ServiceCall::latest()->limit(15)->get();
    }
    return 'Oops!';
});
