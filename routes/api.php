<?php

use App\Http\Controllers\Api\XbrlMessageController;
use App\Http\Middleware\AuthenticateTenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware([AuthenticateTenant::class])->group(function () {
    Route::get('/xbrl-messages', [XbrlMessageController::class, 'index']);
    Route::post('/xbrl-messages', [XbrlMessageController::class, 'store']);
    Route::get('/xbrl-messages/{xbrlMessage}', [XbrlMessageController::class, 'show']);
});
