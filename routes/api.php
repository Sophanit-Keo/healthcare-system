<?php

use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EncounterController;
use App\Http\Controllers\Api\LabOrderController;
use App\Http\Controllers\Api\PatientController;
use App\Http\Controllers\Api\PatientFacilityConsentController;
use App\Http\Controllers\Api\VitalSignController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    Route::apiResource('patients', PatientController::class)->only(['index', 'show', 'store', 'update', 'destroy']);
    Route::apiResource('appointments', AppointmentController::class);
    Route::apiResource('encounters', EncounterController::class);
    Route::apiResource('vital-signs', VitalSignController::class)
        ->parameters(['vital-signs' => 'vitalSign']);
    Route::apiResource('consents', PatientFacilityConsentController::class)
        ->parameters(['consents' => 'patientFacilityConsent']);
    Route::apiResource('lab-orders', LabOrderController::class)
        ->parameters(['lab-orders' => 'labOrder']);
});
