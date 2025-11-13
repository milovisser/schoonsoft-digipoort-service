<?php

use App\Http\Controllers\Api\XbrlMessageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/xbrl-messages', [XbrlMessageController::class, 'index']);
    Route::post('/xbrl-messages', [XbrlMessageController::class, 'store']);
    Route::get('/xbrl-messages/{xbrlMessage}', [XbrlMessageController::class, 'show']);
});
