@extends('layouts.app')

@section('title', 'Manage Appointments')

@section('content')
<div class="row mb-4">
    <div class="col">
        <h2><i class="fas fa-calendar-check"></i> All Appointments</h2>
    </div>
</div>

<div class="card">
    <div class="card-body">
        @if($appointments->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Patient</th>
                            <th>Doctor</th>
                            <th>Date & Time</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($appointments as $appointment)
                            <tr>
                                <td>{{ $appointment->id }}</td>
                                <td>
                                    <strong>{{ $appointment->user->name }}</strong><br>
                                    <small class="text-muted">{{ $appointment->user->email }}</small>
                                </td>
                                <td>
                                    <strong>{{ $appointment->doctor->name }}</strong><br>
                                    <small class="text-muted">{{ $appointment->doctor->specialization }}</small>
                                </td>
                                <td>
                                    <i class="fas fa-calendar"></i> {{ $appointment->appointment_date->format('d M, Y') }}<br>
                                    <i class="fas fa-clock"></i> {{ date('h:i A', strtotime($appointment->appointment_time)) }}
                                </td>
                                <td>
                                    @if($appointment->status == 'pending')
                                        <span class="badge bg-warning">Pending</span>
                                    @elseif($appointment->status == 'approved')
                                        <span class="badge bg-success">Approved</span>
                                    @else
                                        <span class="badge bg-danger">Rejected</span>
                                    @endif
                                </td>
                                <td>
                                    @if($appointment->status == 'pending')
                                        <form action="{{ route('admin.appointments.status', $appointment) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="status" value="approved">
                                            <button type="submit" class="btn btn-sm btn-success">
                                                <i class="fas fa-check"></i> Approve
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.appointments.status', $appointment) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="status" value="rejected">
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-times"></i> Reject
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-muted">No actions</span>
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