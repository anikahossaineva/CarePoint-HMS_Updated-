<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified', 'role:patient'])->group(function () {
    Route::get('/dashboard', [PatientController::class, 'dashboard'])->name('dashboard');
    Route::post('/appointments', [PatientController::class, 'storeAppointment'])->name('patient.appointments.store');
});

Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/departments', [AdminController::class, 'departments'])->name('departments');
    Route::post('/departments', [AdminController::class, 'storeDepartment'])->name('departments.store');
    Route::put('/departments/{department}', [AdminController::class, 'updateDepartment'])->name('departments.update');
    Route::delete('/departments/{department}', [AdminController::class, 'destroyDepartment'])->name('departments.destroy');
    Route::get('/doctors', [AdminController::class, 'doctors'])->name('doctors');
    Route::post('/doctors', [AdminController::class, 'storeDoctor'])->name('doctors.store');
    Route::put('/doctors/{doctor}', [AdminController::class, 'updateDoctor'])->name('doctors.update');
    Route::delete('/doctors/{doctor}', [AdminController::class, 'destroyDoctor'])->name('doctors.destroy');
    Route::get('/patients', [AdminController::class, 'patients'])->name('patients');
    Route::post('/patients', [AdminController::class, 'storePatient'])->name('patients.store');
    Route::put('/patients/{patient}', [AdminController::class, 'updatePatient'])->name('patients.update');
    Route::delete('/patients/{patient}', [AdminController::class, 'destroyPatient'])->name('patients.destroy');
    Route::get('/appointments', [AdminController::class, 'appointments'])->name('appointments');
    Route::patch('/appointments/{appointment}/status', [AdminController::class, 'updateAppointmentStatus'])->name('appointments.status');
    Route::get('/bills', [AdminController::class, 'bills'])->name('bills');
    Route::post('/bills', [AdminController::class, 'storeBill'])->name('bills.store');
    Route::put('/bills/{bill}', [AdminController::class, 'updateBill'])->name('bills.update');
});

Route::middleware(['auth', 'verified', 'role:doctor'])->prefix('doctor')->name('doctor.')->group(function () {
    Route::get('/dashboard', [DoctorController::class, 'dashboard'])->name('dashboard');
    Route::post('/appointments/{appointment}/prescriptions', [DoctorController::class, 'storePrescription'])->name('prescriptions.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
