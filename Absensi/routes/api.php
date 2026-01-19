<?php

use App\Http\Controllers\Api\AttendanceApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/sessions', [AttendanceApiController::class, 'getSessions']);
    Route::put('/attendance/{id}', [AttendanceApiController::class, 'updateAttendance']);
});
