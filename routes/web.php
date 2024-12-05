<?php

use App\Models\Technical;
use Illuminate\Support\Facades\Route;

Route::view('/', 'pages.index');

Route::get('/technical', function () {
    if (app()->environment('local')) {
        return Technical::all();
    }
    return 'Oops!';
});
