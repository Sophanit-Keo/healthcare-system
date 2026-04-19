<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Patient\AppointmentController as PatientAppointmentController;
use App\Http\Controllers\Patient\EncounterController as PatientEncounterController;
use App\Http\Controllers\Patient\ConsentController as PatientConsentController;
use App\Http\Controllers\Patient\LabOrderController as PatientLabOrderController;
use App\Http\Controllers\Admin\PatientController as AdminPatientController;
use App\Http\Controllers\Admin\AppointmentController as AdminAppointmentController;
use App\Http\Controllers\Admin\EncounterController as AdminEncounterController;
use App\Http\Controllers\Admin\LabOrderController as AdminLabOrderController;

Route::get('/', function () {
    // Default entry point: guests go to login, authenticated users go to dashboard.
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

Route::get('/dashboard', DashboardController::class)
    ->middleware(['auth'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:patient'])->prefix('patient')->name('patient.')->group(function () {
    Route::resource('appointments', PatientAppointmentController::class)->only(['index', 'create', 'store', 'show', 'destroy']);
    Route::resource('encounters', PatientEncounterController::class)->only(['index', 'show']);
    Route::resource('consents', PatientConsentController::class)->only(['index', 'store', 'destroy'])
        ->parameters(['consents' => 'consent']);
    Route::resource('lab-orders', PatientLabOrderController::class)->only(['index', 'show'])
        ->parameters(['lab-orders' => 'labOrder']);
});

Route::middleware(['auth', 'role:admin|doctor|nurse|receptionist'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', fn () => redirect()->route('admin.dashboard'));
    Route::get('/dashboard', fn () => view('admin.dashboard'))->name('dashboard');

    Route::resource('patients', AdminPatientController::class)->only(['index', 'show']);
    Route::resource('appointments', AdminAppointmentController::class)->only(['index', 'create', 'store', 'show']);
    Route::resource('encounters', AdminEncounterController::class)->only(['index', 'create', 'store', 'show']);
    Route::resource('lab-orders', AdminLabOrderController::class)->only(['index', 'create', 'store', 'show'])
        ->parameters(['lab-orders' => 'labOrder']);
});
