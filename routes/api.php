<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PatientController;
use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\EncounterController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    Route::get('/patients', [PatientController::class, 'index'])
        ->middleware('permission:patients.view');
    Route::post('/patients', [PatientController::class, 'store'])
        ->middleware('permission:patients.create');
    Route::put('/patients/{patient}', [PatientController::class, 'update'])
        ->middleware('permission:patients.update');
    Route::delete('/patients/{patient}', [PatientController::class, 'destroy'])
        ->middleware('permission:patients.delete');

    Route::apiResource('appointments', AppointmentController::class)
        ->middleware('permission:appointments.view');

    Route::apiResource('encounters', EncounterController::class)
        ->middleware('permission:encounters.view');
});