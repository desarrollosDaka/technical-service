<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\CommentController;
use App\Http\Controllers\Api\V1\MediaController;
use App\Http\Controllers\Api\V1\PartRequestController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\ServiceCallController;
use App\Http\Controllers\Api\V1\TabulatorController;
use App\Http\Controllers\Api\V1\TechnicalVisitController;
use App\Http\Controllers\Api\V1\TicketController;
use App\Http\Middleware\BackendToken;
use App\Models\PartRequest;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);

    // Authenticated routes
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::get('/user', [AuthController::class, 'user']);
        Route::post('/user', [AuthController::class, 'update']);
        Route::apiResource('/tickets', TicketController::class);
        Route::apiResource('/technical-visits', TechnicalVisitController::class);
        Route::patch('/technical-visits/{technicalVisit}/reprogramming', [TechnicalVisitController::class, 'reprogramming']);
        Route::apiResource('/comments', CommentController::class)->only(['index', 'store']);
        Route::apiResource('/media', App\Http\Controllers\Api\V1\MediaController::class)->except(['update']);
        Route::apiResource('/products', ProductController::class)->only(['index']);
        Route::apiResource('/tabulators', TabulatorController::class)->only(['index']);
        Route::apiResource('/part-requests', PartRequestController::class);
    });

    Route::apiResource('/guest-comments', CommentController::class)->only(['index', 'store']);

    Route::group(['middleware' => BackendToken::class], function () {
        Route::apiResource('/service-calls', ServiceCallController::class);
        Route::apiResource('/technicians', App\Http\Controllers\Api\V1\TechnicalController::class);
        Route::apiResource('/products', ProductController::class)->only(['store']);
        Route::apiResource('/tabulators', TabulatorController::class)->only(['store']);

        Route::group(['prefix' => 'sync'], function () {
            Route::get('/part-requests', [PartRequestController::class, 'sync']);
            Route::post('/part-requests', [PartRequestController::class, 'syncStatus']);
            Route::get('/service-calls', [ServiceCallController::class, 'sync']);
        });

        Route::group(['prefix' => 'external'], function () {
            Route::get('/tickets', [TicketController::class, 'externalGet']);
            Route::get('/tickets/{ticket}', [TicketController::class, 'externalFindGet']);
            Route::get('/comments', [CommentController::class, 'externalGet']);
            Route::get('/technical-visits', [TechnicalVisitController::class, 'externalGet']);
            Route::get('/technical-visits/{technicalVisit}', [TechnicalVisitController::class, 'externalFindGet']);
            Route::get('/media', [MediaController::class, 'externalGet']);
        });
    });
});
