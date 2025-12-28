@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="row mb-4">
    <div class="col">
        <h2><i class="fas fa-tachometer-alt"></i> Admin Dashboard</h2>
        <p class="text-muted">Welcome back, {{ auth()->user()->name }}!</p>
    </div>
</div>

<div class="row">
    <div class="col-md-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-uppercase mb-0">Total Doctors</h6>
                        <h2 class="mb-0">{{ $stats['total_doctors'] }}</h2>
                    </div>
                    <div>
                        <i class="fas fa-user-md fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-transparent">
                <a href="{{ route('doctors.index') }}" class="text-white text-decoration-none">
                    View Details <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-uppercase mb-0">Total Patients</h6>
                        <h2 class="mb-0">{{ $stats['total_patients'] }}</h2>
                    </div>
                    <div>
                        <i class="fas fa-users fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-transparent">
                <span class="text-white">Registered Users</span>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-uppercase mb-0">Pending</h6>
                        <h2 class="mb-0">{{ $stats['pending_appointments'] }}</h2>
                    </div>
                    <div>
                        <i class="fas fa-clock fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-transparent">
                <a href="{{ route('admin.appointments') }}" class="text-white text-decoration-none">
                    Review Now <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-uppercase mb-0">All Appointments</h6>
                        <h2 class="mb-0">{{ $stats['total_appointments'] }}</h2>
                    </div>
                    <div>
                        <i class="fas fa-calendar-check fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-transparent">
                <a href="{{ route('admin.appointments') }}" class="text-white text-decoration-none">
                    View All <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-chart-line"></i> Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <a href="{{ route('doctors.create') }}" class="btn btn-primary btn-lg w-100">
                            <i class="fas fa-plus-circle"></i> Add New Doctor
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="{{ route('doctors.index') }}" class="btn btn-secondary btn-lg w-100">
                            <i class="fas fa-list"></i> Manage Doctors
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="{{ route('admin.appointments') }}" class="btn btn-info btn-lg w-100">
                            <i class="fas fa-calendar-alt"></i> View Appointments
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection