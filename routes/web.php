<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PatientsController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\DoctorsController;

Route::get('/', function () {
    return view('user.home');
})->name('home');

Route::get('/dashboard', [HomeController::class, 'redirect'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

Route::post('/appointment', [AppointmentController::class, 'store'])->name('appointment.store');

Route::middleware('auth')->group(function () {
    Route::get('/patient/chat', [PatientController::class, 'chat'])->name('patient.chat');
    Route::post('/patient/chat', [PatientController::class, 'sendMessage'])->name('patient.send-message');
    Route::get('/patient/records', [PatientController::class, 'records'])->name('patient.records');
    Route::get('/patient/lab-test', [PatientController::class, 'labTestForm'])->name('patient.lab-test');
    Route::post('/patient/lab-test', [PatientController::class, 'bookLabTest'])->name('patient.lab-test.book');
    Route::get('/patient/lab-results', [PatientController::class, 'labResults'])->name('patient.lab-results');
});

Route::middleware('auth', 'admin')->group(function () {
    Route::get('patients', [PatientsController::class, 'index'])->name('admin.patients.index');
    Route::get('patients/create', [PatientsController::class, 'create'])->name('admin.patients.create');
    Route::post('patients', [PatientsController::class, 'store'])->name('admin.patients.store');
    Route::get('patients/{patient}/edit', [PatientsController::class, 'edit'])->name('admin.patients.edit');
    Route::put('patients/{patient}', [PatientsController::class, 'update'])->name('admin.patients.update');
    Route::delete('patients/{patient}', [PatientsController::class, 'destroy'])->name('admin.patients.destroy');

    Route::get('admin/appointments', [AppointmentController::class, 'index'])->name('admin.appointments.index');
    Route::get('admin/appointments/create', [AppointmentController::class, 'create'])->name('admin.appointments.create');
    Route::post('admin/appointments', [AppointmentController::class, 'store'])->name('admin.appointments.store');
    Route::delete('admin/appointments/{appointment}', [AppointmentController::class, 'destroy'])->name('admin.appointments.destroy');

    Route::get('admin/doctors', [DoctorsController::class, 'index'])->name('admin.doctors.index');
    Route::get('admin/doctors/create', [DoctorsController::class, 'create'])->name('admin.doctors.create');
    Route::post('admin/doctors', [DoctorsController::class, 'store'])->name('admin.doctors.store');
    Route::get('admin/doctors/{doctor}/edit', [DoctorsController::class, 'edit'])->name('admin.doctors.edit');
    Route::put('admin/doctors/{doctor}', [DoctorsController::class, 'update'])->name('admin.doctors.update');
    Route::delete('admin/doctors/{doctor}', [DoctorsController::class, 'destroy'])->name('admin.doctors.destroy');
});

require __DIR__ . '/auth.php';

