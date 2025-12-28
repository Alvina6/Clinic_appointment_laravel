@extends('layouts.app')

@section('title', 'Reschedule Appointment')

@section('content')
<div class="row mb-4">
    <div class="col">
        <h2><i class="fas fa-calendar-alt"></i> Reschedule Appointment</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('patient.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('patient.appointments.history') }}">My Appointments</a></li>
                <li class="breadcrumb-item active">Reschedule</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-header bg-warning text-white">
                <h5 class="mb-0"><i class="fas fa-info-circle"></i> Current Appointment</h5>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <i class="fas fa-user-md fa-4x text-primary"></i>
                </div>
                <h5 class="text-center">{{ $appointment->doctor->name }}</h5>
                <p class="text-center">
                    <span class="badge bg-info">{{ $appointment->doctor->specialization }}</span>
                </p>
                <hr>
                
                <div class="alert alert-warning">
                    <p class="mb-1"><strong>Current Date:</strong></p>
                    <p class="mb-1">{{ $appointment->appointment_date->format('l, d M Y') }}</p>
                    
                    <p class="mb-1 mt-2"><strong>Current Time:</strong></p>
                    <p class="mb-0">{{ date('h:i A', strtotime($appointment->appointment_time)) }}</p>
                </div>

                <div class="mb-3">
                    <p><strong><i class="fas fa-clock"></i> Available Time:</strong></p>
                    <p class="text-muted">{{ $appointment->doctor->available_from }} - {{ $appointment->doctor->available_to }}</p>
                </div>

                <div class="mb-3">
                    <p><strong><i class="fas fa-calendar"></i> Available Days:</strong></p>
                    @php
                        $days = json_decode($appointment->doctor->available_days, true) ?? [];
                        $dayNames = [
                            'Mon' => 'Monday',
                            'Tue' => 'Tuesday', 
                            'Wed' => 'Wednesday',
                            'Thu' => 'Thursday',
                            'Fri' => 'Friday',
                            'Sat' => 'Saturday',
                            'Sun' => 'Sunday'
                        ];
                    @endphp
                    <div class="d-flex flex-wrap gap-1">
                        @foreach(['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'] as $day)
                            @if(in_array($day, $days))
                                <span class="badge bg-success">{{ $dayNames[$day] }}</span>
                            @else
                                <span class="badge bg-secondary opacity-25">{{ $dayNames[$day] }}</span>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">New Appointment Details</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('patient.appointments.reschedule.update', $appointment->id) }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="appointment_date" class="form-label">New Appointment Date *</label>
                        <input type="date" 
                               class="form-control @error('appointment_date') is-invalid @enderror" 
                               id="appointment_date" 
                               name="appointment_date" 
                               value="{{ old('appointment_date', $appointment->appointment_date->format('Y-m-d')) }}" 
                               min="{{ date('Y-m-d') }}" 
                               required>
                        @error('appointment_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">
                            <i class="fas fa-info-circle"></i> 
                            Please select a day when the doctor is available
                        </small>
                    </div>

                    <div class="mb-3">
                        <label for="appointment_time" class="form-label">New Appointment Time *</label>
                        <input type="time" 
                               class="form-control @error('appointment_time') is-invalid @enderror" 
                               id="appointment_time" 
                               name="appointment_time" 
                               value="{{ old('appointment_time', $appointment->appointment_time) }}" 
                               min="{{ $appointment->doctor->available_from }}"
                               max="{{ $appointment->doctor->available_to }}"
                               required>
                        @error('appointment_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">
                            <i class="fas fa-info-circle"></i> 
                            Doctor available: {{ $appointment->doctor->available_from }} - {{ $appointment->doctor->available_to }}
                        </small>
                    </div>

                    <div class="mb-3">
                        <label for="reason" class="form-label">Reason for Visit (Optional)</label>
                        <textarea class="form-control @error('reason') is-invalid @enderror" 
                                  id="reason" 
                                  name="reason" 
                                  rows="4" 
                                  placeholder="Update your reason if needed">{{ old('reason', $appointment->reason) }}</textarea>
                        @error('reason')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror>
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> 
                        After rescheduling, your appointment will still be in pending status.
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-calendar-check"></i> Reschedule Appointment
                        </button>
                        <a href="{{ route('patient.appointments.history') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Disable past dates
    document.addEventListener('DOMContentLoaded', function() {
        const dateInput = document.getElementById('appointment_date');
        const today = new Date().toISOString().split('T')[0];
        dateInput.min = today;

        // Available days validation
        const availableDays = @json(json_decode($appointment->doctor->available_days, true) ?? []);
        const dayMap = {
            0: 'Sun',
            1: 'Mon',
            2: 'Tue',
            3: 'Wed',
            4: 'Thu',
            5: 'Fri',
            6: 'Sat'
        };

        dateInput.addEventListener('change', function() {
            const selectedDate = new Date(this.value);
            const dayName = dayMap[selectedDate.getDay()];
            
            if (!availableDays.includes(dayName)) {
                alert('Doctor is not available on this day. Please select another date.');
                this.value = '';
            }
        });
    });
</script>
@endsection