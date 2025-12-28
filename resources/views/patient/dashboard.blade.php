@extends('layouts.app')

@section('title', 'Patient Dashboard')

@section('content')
<div class="row mb-4">
    <div class="col">
        <h2><i class="fas fa-home"></i> Welcome, {{ auth()->user()->name }}!</h2>
        <p class="text-muted">Book your appointment with our experienced doctors</p>
    </div>
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h6 class="text-uppercase mb-0">Total Appointments</h6>
                <h2 class="mb-0">{{ $total_appointments }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <h6 class="text-uppercase mb-0">Pending</h6>
                <h2 class="mb-0">{{ $pending_appointments }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h6 class="text-uppercase mb-0">Completed</h6>
                <h2 class="mb-0">{{ $completed_appointments }}</h2>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h5 class="card-title"><i class="fas fa-calendar-plus"></i> Book New Appointment</h5>
                <p class="card-text">Browse our doctors and schedule your visit</p>
                <a href="{{ route('patient.appointments') }}" class="btn btn-light">
                    Browse Doctors <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h5 class="card-title"><i class="fas fa-history"></i> My Appointments</h5>
                <p class="card-text">View and manage your appointment history</p>
                <a href="{{ route('patient.appointments.history') }}" class="btn btn-light">
                    View History <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Featured Doctors -->
<div class="row mb-4">
    <div class="col">
        <h4><i class="fas fa-star"></i> Featured Doctors</h4>
    </div>
</div>

<div class="row">
    @forelse($doctors as $doctor)
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="text-center mb-3">
                        <i class="fas fa-user-md fa-4x text-primary"></i>
                    </div>
                    <h5 class="card-title text-center">{{ $doctor->name }}</h5>
                    <p class="text-center">
                        <span class="badge bg-info">{{ $doctor->specialization }}</span>
                    </p>
                    <p class="card-text">
                        <i class="fas fa-clock text-muted"></i> 
                        <strong>Timing:</strong> {{ $doctor->timing }}
                    </p>
                    @if($doctor->description)
                        <p class="card-text text-muted small">{{ Str::limit($doctor->description, 100) }}</p>
                    @endif
                </div>
                <div class="card-footer bg-transparent">
                    <a href="{{ route('patient.appointments.create', $doctor) }}" class="btn btn-primary w-100">
                        <i class="fas fa-calendar-plus"></i> Book Appointment
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle"></i> No doctors available at the moment.
            </div>
        </div>
    @endforelse
</div>

@if($doctors->count() > 0)
    <div class="text-center mt-3">
        <a href="{{ route('patient.appointments') }}" class="btn btn-outline-primary">
            View All Doctors <i class="fas fa-arrow-right"></i>
        </a>
    </div>
@endif
@endsection