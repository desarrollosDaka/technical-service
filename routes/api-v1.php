<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\CommentController;
use App\Http\Middleware\BackendToken;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);

    // Authenticated routes
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::get('/user', [AuthController::class, 'user']);
        Route::apiResource('/tickets', App\Http\Controllers\Api\V1\TicketController::class);
        Route::apiResource('/technical-visits', App\Http\Controllers\Api\V1\TechnicalVisitController::class);
        Route::apiResource('/comments', CommentController::class)->only(['index', 'store']);
        Route::apiResource('/media', App\Http\Controllers\Api\V1\MediaController::class)->except(['update']);
    });

    Route::apiResource('/guest-comments', CommentController::class)->only(['index', 'store']);

    Route::group(['middleware' => BackendToken::class], function () {
        Route::apiResource('/service-calls', App\Http\Controllers\Api\V1\ServiceCallController::class);
        Route::apiResource('/technicians', App\Http\Controllers\Api\V1\TechnicalController::class);
    });
});
