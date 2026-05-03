<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MoveController;
use App\Http\Controllers\Api\VoteController;
use App\Http\Controllers\Api\v1\ApiMoveController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/moves', [MoveController::class, 'index']);
        Route::post('/moves', [MoveController::class, 'store']);
        Route::post('/moves/{move}/vote', [VoteController::class, 'store']);
    });
});

Route::apiResource('v1/moves', ApiMoveController::class)
    ->middlewareFor(['index', 'show'], ['auth:sanctum', 'abilities:moves:read'])
    ->middlewareFor(['store'], ['auth:sanctum', 'abilities:moves:create'])
    ->middlewareFor(['update'], ['auth:sanctum', 'abilities:moves:update'])
    ->middlewareFor(['destroy'], ['auth:sanctum', 'abilities:moves:delete']);
