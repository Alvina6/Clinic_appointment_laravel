@extends('layouts.app')

@section('title', 'Browse Doctors')

@section('content')
<div class="row mb-4">
    <div class="col">
        <h2><i class="fas fa-user-md"></i> Browse Our Doctors</h2>
        <p class="text-muted">Select a doctor to book your appointment</p>
    </div>
</div>

<div class="row">
    @forelse($doctors as $doctor)
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <div class="text-center mb-3">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px;">
                            <i class="fas fa-user-md fa-3x text-primary"></i>
                        </div>
                    </div>
                    <h5 class="card-title text-center mb-3">{{ $doctor->name }}</h5>
                    <div class="text-center mb-3">
                        <span class="badge bg-info px-3 py-2">{{ $doctor->specialization }}</span>
                    </div>
                    
                    <div class="mb-2">
                        <i class="fas fa-clock text-primary"></i> 
                        <strong>Available Time:</strong><br>
                        <small>{{ $doctor->available_from }} - {{ $doctor->available_to }}</small>
                    </div>

                    <div class="mb-2">
                        <i class="fas fa-calendar text-primary"></i> 
                        <strong>Available Days:</strong><br>
                        @php
                            $days = json_decode($doctor->available_days, true) ?? [];
                            $dayNames = [
                                'Mon' => 'Mon',
                                'Tue' => 'Tue', 
                                'Wed' => 'Wed',
                                'Thu' => 'Thu',
                                'Fri' => 'Fri',
                                'Sat' => 'Sat',
                                'Sun' => 'Sun'
                            ];
                        @endphp
                        <div class="d-flex flex-wrap gap-1 mt-1">
                            @foreach(['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'] as $day)
                                @if(in_array($day, $days))
                                    <span class="badge bg-success">{{ $day }}</span>
                                @else
                                    <span class="badge bg-secondary opacity-25">{{ $day }}</span>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    
                    @if($doctor->description)
                        <p class="card-text text-muted small mt-3">
                            {{ Str::limit($doctor->description, 100) }}
                        </p>
                    @endif
                </div>
                <div class="card-footer bg-white border-top">
                    <a href="{{ route('patient.appointments.create', $doctor) }}" 
                       class="btn btn-primary w-100">
                        <i class="fas fa-calendar-plus"></i> Book Appointment
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle"></i> No doctors available at the moment. Please check back later.
            </div>
        </div>
    @endforelse
</div>
@endsection