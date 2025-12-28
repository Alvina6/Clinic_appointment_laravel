@extends('layouts.app')

@section('title', 'My Appointments')

@section('content')
<div class="row mb-4">
    <div class="col-md-6">
        <h2><i class="fas fa-history"></i> My Appointments</h2>
    </div>
    <div class="col-md-6 text-end">
        <a href="{{ route('patient.appointments') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Book New Appointment
        </a>
    </div>
</div>

@if($appointments->count() > 0)
    <div class="row">
        @foreach($appointments as $appointment)
            <div class="col-md-12 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-2 text-center">
                                <i class="fas fa-user-md fa-3x text-primary"></i>
                            </div>
                            <div class="col-md-3">
                                <h5 class="mb-1">{{ $appointment->doctor->name }}</h5>
                                <p class="mb-0 text-muted">
                                    <span class="badge bg-info">{{ $appointment->doctor->specialization }}</span>
                                </p>
                            </div>
                            <div class="col-md-3">
                                <p class="mb-1">
                                    <i class="fas fa-calendar text-primary"></i> 
                                    <strong>{{ $appointment->appointment_date->format('d M, Y') }}</strong>
                                </p>
                                <p class="mb-0">
                                    <i class="fas fa-clock text-primary"></i> 
                                    {{ date('h:i A', strtotime($appointment->appointment_time)) }}
                                </p>
                            </div>
                            <div class="col-md-2 text-center">
                                @if($appointment->status == 'pending')
                                    <span class="badge bg-warning text-dark px-3 py-2">
                                        <i class="fas fa-clock"></i> Pending
                                    </span>
                                @elseif($appointment->status == 'approved')
                                    <span class="badge bg-success px-3 py-2">
                                        <i class="fas fa-check-circle"></i> Approved
                                    </span>
                                @elseif($appointment->status == 'completed')
                                    <span class="badge bg-info px-3 py-2">
                                        <i class="fas fa-check-double"></i> Completed
                                    </span>
                                @elseif($appointment->status == 'cancelled')
                                    <span class="badge bg-secondary px-3 py-2">
                                        <i class="fas fa-ban"></i> Cancelled
                                    </span>
                                @else
                                    <span class="badge bg-danger px-3 py-2">
                                        <i class="fas fa-times-circle"></i> Rejected
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-2 text-center">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" 
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i> Actions
                                    </button>
                                    <ul class="dropdown-menu">
                                        <!-- View Details -->
                                        <li>
                                            <button class="dropdown-item" type="button" 
                                                    data-bs-toggle="collapse" 
                                                    data-bs-target="#details-{{ $appointment->id }}">
                                                <i class="fas fa-info-circle text-info"></i> View Details
                                            </button>
                                        </li>

                                        <!-- Reschedule (only for pending) -->
                                        @if($appointment->status == 'pending')
                                            <li>
                                                <a class="dropdown-item" href="{{ route('patient.appointments.reschedule', $appointment->id) }}">
                                                    <i class="fas fa-calendar-alt text-warning"></i> Reschedule
                                                </a>
                                            </li>
                                        @endif

                                        <!-- Cancel (only for pending/approved) -->
                                        @if(in_array($appointment->status, ['pending', 'approved']))
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form action="{{ route('patient.appointments.cancel', $appointment->id) }}" 
                                                      method="POST" 
                                                      onsubmit="return confirm('Are you sure you want to cancel this appointment?');">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item text-danger">
                                                        <i class="fas fa-times-circle"></i> Cancel Appointment
                                                    </button>
                                                </form>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Collapsible Details -->
                        @if($appointment->reason)
                            <div class="collapse mt-3" id="details-{{ $appointment->id }}">
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <p class="mb-1"><strong>Reason for Visit:</strong></p>
                                        <p class="text-muted">{{ $appointment->reason }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="card-footer bg-light text-muted small">
                        <i class="fas fa-clock"></i> Booked on: {{ $appointment->created_at->format('d M, Y h:i A') }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-3">
        {{ $appointments->links() }}
    </div>
@else
    <div class="card">
        <div class="card-body text-center py-5">
            <i class="fas fa-calendar-times fa-4x text-muted mb-3"></i>
            <h4>No Appointments Yet</h4>
            <p class="text-muted">You haven't booked any appointments. Start by browsing our doctors.</p>
            <a href="{{ route('patient.appointments') }}" class="btn btn-primary">
                <i class="fas fa-user-md"></i> Browse Doctors
            </a>
        </div>
    </div>
@endif
@endsection