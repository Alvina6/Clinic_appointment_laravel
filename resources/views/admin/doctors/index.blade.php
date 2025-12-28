@extends('layouts.app')

@section('title', 'Manage Doctors')

@section('content')
<div class="row mb-4">
    <div class="col-md-6">
        <h2><i class="fas fa-user-md"></i> Manage Doctors</h2>
    </div>
    <div class="col-md-6 text-end">
        <a href="{{ route('doctors.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Doctor
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        @if($doctors->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Specialization</th>
                            <th>Timing</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($doctors as $doctor)
                            <tr>
                                <td>{{ $doctor->id }}</td>
                                <td>
                                    <strong>{{ $doctor->name }}</strong>
                                </td>
                                <td>
                                    <span class="badge bg-info">
                                        {{ $doctor->specialization }}
                                    </span>
                                </td>
                                <td>
                                    {{ $doctor->available_from }} - {{ $doctor->available_to }}
                                </td>
                                <td>
                                    <a href="{{ route('doctors.edit', $doctor) }}" 
                                       class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>

                                    <form action="{{ route('doctors.destroy', $doctor) }}" 
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete this doctor?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle"></i>
                No doctors found. Add your first doctor!
            </div>
        @endif
    </div>
</div>
@endsection
