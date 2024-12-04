<?php

use App\Models\Technical;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/technical', function () {
    if (app()->environment('local')) {
        return Technical::all();
    }
    return 'Oops!';
});
