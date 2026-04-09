<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PatientsController;


Route::get('/', function () {
    return view('user.home');
})->name('home');

// Route::prefix('admin')->group(function () {
//     Route::resource('patients', PatientsController::class);
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', [HomeController::class, 'redirect'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/admin.layout', function () {
    return view('admin.layout');
})->name('admin.layout');




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

Route::middleware('auth', 'admin')->group(function () {
    Route::get('patients', [PatientsController::class, 'index'])->name('admin.patients.index');
    Route::get('patients/create', [PatientsController::class, 'create'])->name('admin.patients.create');
    Route::post('patients', [PatientsController::class, 'store'])->name('admin.patients.store');
    Route::get('patients/{patient}', [PatientsController::class, 'show'])->name('admin.patients.show');
    Route::get('patients/{patient}/edit', [PatientsController::class, 'edit'])->name('admin.patients.edit');
    Route::put('patients/{patient}', [PatientsController::class, 'update'])->name('admin.patients.update');
    Route::delete('patients/{patient}', [PatientsController::class, 'destroy'])->name('admin.patients.destroy');
    Route::get('patients/search', [PatientsController::class, 'search'])->name('admin.patients.search');
});



require __DIR__ . '/auth.php';
