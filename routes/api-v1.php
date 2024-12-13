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
        Route::post('/user', [AuthController::class, 'update']);
        Route::apiResource('/tickets', App\Http\Controllers\Api\V1\TicketController::class);
        Route::apiResource('/technical-visits', App\Http\Controllers\Api\V1\TechnicalVisitController::class);
        Route::patch('/technical-visits/{technicalVisit}/reprogramming', [App\Http\Controllers\Api\V1\TechnicalVisitController::class, 'reprogramming']);
        Route::apiResource('/comments', CommentController::class)->only(['index', 'store']);
        Route::apiResource('/media', App\Http\Controllers\Api\V1\MediaController::class)->except(['update']);
    });

    Route::apiResource('/guest-comments', CommentController::class)->only(['index', 'store']);

    Route::group(['middleware' => BackendToken::class], function () {
        Route::apiResource('/service-calls', App\Http\Controllers\Api\V1\ServiceCallController::class);
        Route::apiResource('/technicians', App\Http\Controllers\Api\V1\TechnicalController::class);
        Route::apiResource('/products', App\Http\Controllers\Api\V1\ProductController::class);
        Route::apiResource('/tabulators', App\Http\Controllers\Api\V1\TabulatorController::class);
    });
});
