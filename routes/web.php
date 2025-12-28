<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AppointmentsController;

// Welcome page
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Authentication routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard redirect
Route::get('/dashboard', function () {
    if (session()->has('doctor')) {
        return redirect()->route('doctor.dashboard');
    }
    
    if (!auth()->check()) {
        return redirect()->route('login');
    }
    
    if (auth()->user()->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    
    return redirect()->route('patient.dashboard');
})->name('dashboard');

// ========== ADMIN ROUTES ==========
Route::prefix('admin')->group(function () {
    
    Route::get('/dashboard', function () {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            return redirect()->route('login')->with('error', 'Please login as admin');
        }
        return app(AdminController::class)->dashboard();
    })->name('admin.dashboard');
    
    Route::get('/appointments', function () {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            return redirect()->route('login')->with('error', 'Please login as admin');
        }
        return app(AdminController::class)->appointments();
    })->name('admin.appointments');
    
    Route::post('/appointments/{appointment}/status', function ($appointmentId) {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }
        $appointment = \App\Models\Appointment::findOrFail($appointmentId);
        return app(AdminController::class)->updateAppointmentStatus(request(), $appointment);
    })->name('admin.appointments.status');
    
    // Doctor CRUD
    Route::get('/doctors', function () {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            return redirect()->route('login')->with('error', 'Please login as admin');
        }
        return app(DoctorController::class)->index();
    })->name('doctors.index');
    
    Route::get('/doctors/create', function () {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            return redirect()->route('login')->with('error', 'Please login as admin');
        }
        return app(DoctorController::class)->create();
    })->name('doctors.create');
    
    Route::post('/doctors', function () {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            return redirect()->route('login')->with('error', 'Please login as admin');
        }
        return app(DoctorController::class)->store(request());
    })->name('doctors.store');
    
    Route::get('/doctors/{doctor}/edit', function ($doctorId) {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            return redirect()->route('login')->with('error', 'Please login as admin');
        }
        $doctor = \App\Models\Doctor::findOrFail($doctorId);
        return app(DoctorController::class)->edit($doctor);
    })->name('doctors.edit');
    
    Route::put('/doctors/{doctor}', function ($doctorId) {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            return redirect()->route('login')->with('error', 'Please login as admin');
        }
        $doctor = \App\Models\Doctor::findOrFail($doctorId);
        return app(DoctorController::class)->update(request(), $doctor);
    })->name('doctors.update');
    
    Route::delete('/doctors/{doctor}', function ($doctorId) {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }
        $doctor = \App\Models\Doctor::findOrFail($doctorId);
        return app(DoctorController::class)->destroy($doctor);
    })->name('doctors.destroy');
});

// ========== PATIENT ROUTES ==========
Route::prefix('patient')->group(function () {
    
    Route::get('/dashboard', function () {
        if (!auth()->check() || auth()->user()->isAdmin()) {
            return redirect()->route('login')->with('error', 'Please login as patient');
        }
        return app(PatientController::class)->dashboard();
    })->name('patient.dashboard');
    
    Route::get('/appointments', function () {
        if (!auth()->check() || auth()->user()->isAdmin()) {
            return redirect()->route('login')->with('error', 'Please login as patient');
        }
        return app(AppointmentsController::class)->index();
    })->name('patient.appointments');
    
    Route::get('/appointments/create/{doctor}', function ($doctorId) {
        if (!auth()->check() || auth()->user()->isAdmin()) {
            return redirect()->route('login')->with('error', 'Please login as patient');
        }
        $doctor = \App\Models\Doctor::findOrFail($doctorId);
        return app(AppointmentsController::class)->create($doctor);
    })->name('patient.appointments.create');
    
    Route::post('/appointments', function () {
        if (!auth()->check() || auth()->user()->isAdmin()) {
            return redirect()->route('login')->with('error', 'Please login as patient');
        }
        return app(AppointmentsController::class)->store(request());
    })->name('patient.appointments.store');
    
    Route::get('/appointments/history', function () {
        if (!auth()->check() || auth()->user()->isAdmin()) {
            return redirect()->route('login')->with('error', 'Please login as patient');
        }
        return app(AppointmentsController::class)->history();
    })->name('patient.appointments.history');

    // Cancel appointment
    Route::post('/appointments/{appointment}/cancel', function ($appointmentId) {
        if (!auth()->check() || auth()->user()->isAdmin()) {
            return redirect()->route('login')->with('error', 'Please login as patient');
        }
        return app(AppointmentsController::class)->cancel($appointmentId);
    })->name('patient.appointments.cancel');

    // Reschedule appointment
    Route::get('/appointments/{appointment}/reschedule', function ($appointmentId) {
        if (!auth()->check() || auth()->user()->isAdmin()) {
            return redirect()->route('login')->with('error', 'Please login as patient');
        }
        return app(AppointmentsController::class)->reschedule($appointmentId);
    })->name('patient.appointments.reschedule');

    Route::post('/appointments/{appointment}/reschedule', function ($appointmentId) {
        if (!auth()->check() || auth()->user()->isAdmin()) {
            return redirect()->route('login')->with('error', 'Please login as patient');
        }
        return app(AppointmentsController::class)->updateReschedule(request(), $appointmentId);
    })->name('patient.appointments.reschedule.update');
});

// ========== DOCTOR ROUTES ==========
Route::prefix('doctor')->group(function () {
    
    Route::get('/dashboard', function () {
        if (!session()->has('doctor')) {
            return redirect()->route('login')->with('error', 'Please login as doctor');
        }
        return app(DoctorController::class)->doctorDashboard();
    })->name('doctor.dashboard');
    
    Route::get('/appointments', function () {
        if (!session()->has('doctor')) {
            return redirect()->route('login')->with('error', 'Please login as doctor');
        }
        return app(DoctorController::class)->doctorAppointments();
    })->name('doctor.appointments');
    
    Route::post('/appointments/{appointment}/status', function ($appointmentId) {
        if (!session()->has('doctor')) {
            return redirect()->route('login')->with('error', 'Please login as doctor');
        }
        return app(DoctorController::class)->updateDoctorAppointmentStatus($appointmentId, request());
    })->name('doctor.appointments.status');
});