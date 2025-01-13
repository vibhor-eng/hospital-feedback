<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\PatientAuthController;
use App\Http\Controllers\Auth\HospitalAuthController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\patient\DashboardController;
use App\Http\Controllers\hospital\HospitalDashboardController;
use App\Http\Controllers\hospital\QueryController;

Route::prefix('patient')->group(function () {
    Route::get('login', [PatientAuthController::class, 'showLoginForm'])->name('patient.login.form');
    Route::post('login', [PatientAuthController::class, 'login'])->name('patient.login');
    Route::get('logout', [PatientAuthController::class, 'logout'])->name('patient.logout');
    Route::get('register', [PatientAuthController::class, 'showRegisterForm'])->name('patient.register.form');
    Route::post('register', [PatientAuthController::class, 'register'])->name('patient.register');
});

Route::prefix('hospital')->group(function () {
    Route::get('login', [HospitalAuthController::class, 'showLoginForm'])->name('hospital.login.form');
    Route::post('login', [HospitalAuthController::class, 'login'])->name('hospital.login');
    Route::get('logout', [HospitalAuthController::class, 'logout'])->name('hospital.logout');
//     Route::get('logout', [PatientAuthController::class, 'logout'])->name('patient.logout');
//     Route::get('register', [PatientAuthController::class, 'showRegisterForm'])->name('patient.register.form');
//     Route::post('register', [PatientAuthController::class, 'register'])->name('patient.register');
});
    
##these two routes will use without auth
Route::get('patient/feedback', [DashboardController::class, 'feedbackForm'])->name('patient.feedback');
Route::post('patient/feedback', [DashboardController::class, 'feedbackForm'])->name('patient.feedback');
##end


Route::middleware(['auth:web'])->group(function () {
    Route::get('patient/dashboard', [DashboardController::class, 'dashboard'])->name('patient.dashboard');
});

Route::middleware(['auth:admin'])->group(function () {
    Route::get('hospital/dashboard', [HospitalDashboardController::class, 'dashboard'])->name('hospital.dashboard');

    ##patient
    Route::get('hospital/patient-reset-password', [HospitalDashboardController::class, 'resetPassword'])->name('hospital.reset-password');
    Route::get('hospital/patient-list', [HospitalDashboardController::class, 'PatientList'])->name('hospital.patient.list');
    Route::get('hospital/patient/update/{id}', [HospitalDashboardController::class, 'UpdatePatientList']);
    Route::post('hospital/patient/update', [HospitalDashboardController::class, 'UpdatePatientList'])->name('hospital.patient.update');
    Route::get('hospital/patient-queries', [HospitalDashboardController::class, 'PatientQueryList'])->name('hospital.patient.queries');

    ##query
    Route::get('hospital/query/list', [QueryController::class, 'queryList'])->name('hospital.query.list');

    Route::post('hospital/query/create', [QueryController::class, 'Addquery'])->name('hospital.query.create');

    Route::post('hospital/query/delete', [QueryController::class, 'Deletequery'])->name('hospital.query.delete');

    Route::post('hospital/query/update', [QueryController::class, 'Updatequery'])->name('hospital.query.update');

    Route::post('hospital/reply', [HospitalDashboardController::class, 'reply']);

    Route::post('hospital/update-dept', [HospitalDashboardController::class, 'updateDept']);

    Route::post('hospital/patient-reset-password', [HospitalDashboardController::class, 'resetPassword'])->name('hospital.reset-password');
});