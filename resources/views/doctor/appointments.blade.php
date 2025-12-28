@extends('layouts.app')

@section('title', 'My Appointments')

@section('content')
<div class="row mb-4">
    <div class="col">
        <h2><i class="fas fa-calendar-check"></i> My Appointments</h2>
        <p class="text-muted">Manage your patient appointments</p>
    </div>
</div>

<div class="card">
    <div class="card-body">
        @if($appointments->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Patient</th>
                            <th>Date & Time</th>
                            <th>Reason</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($appointments as $appointment)
                            <tr>
                                <td>
                                    <strong>{{ $appointment->user->name }}</strong><br>
                                    <small class="text-muted">{{ $appointment->user->email }}</small>
                                </td>
                                <td>
                                    <i class="fas fa-calendar"></i> {{ $appointment->appointment_date->format('d M, Y') }}<br>
                                    <i class="fas fa-clock"></i> {{ date('h:i A', strtotime($appointment->appointment_time)) }}
                                </td>
                                <td>{{ $appointment->reason ?? 'Routine checkup' }}</td>
                                <td>
                                    @if($appointment->status == 'pending')
                                        <span class="badge bg-warning">Pending</span>
                                    @elseif($appointment->status == 'approved')
                                        <span class="badge bg-success">Approved</span>
                                    @elseif($appointment->status == 'completed')
                                        <span class="badge bg-info">Completed</span>
                                    @else
                                        <span class="badge bg-secondary">{{ ucfirst($appointment->status) }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if(in_array($appointment->status, ['completed', 'cancelled']))
                                        <!-- Can't change completed or cancelled -->
                                        <span class="badge bg-secondary">
                                            <i class="fas fa-lock"></i> Locked
                                        </span>
                                    @else
                                        <form action="{{ route('doctor.appointments.status', $appointment->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <select name="status" class="form-select form-select-sm d-inline w-auto" onchange="this.form.submit()">
                                                <option value="pending" {{ $appointment->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="completed" {{ $appointment->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                            </select>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="mt-3">
                {{ $appointments->links() }}
            </div>
        @else
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle"></i> No appointments found.
            </div>
        @endif
    </div>
</div>
@endsection