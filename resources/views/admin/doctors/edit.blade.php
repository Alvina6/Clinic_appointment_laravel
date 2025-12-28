@extends('layouts.app')

@section('title', 'Edit Doctor')

@section('content')
<div class="row mb-4">
    <div class="col">
        <h2><i class="fas fa-edit"></i> Edit Doctor</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('doctors.index') }}">Doctors</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Update Doctor Information</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('doctors.update', $doctor) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Doctor Name *</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', $doctor->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address *</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email', $doctor->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password (Leave blank to keep current)</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               id="password" name="password" placeholder="Only fill to change password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="specialization" class="form-label">Specialization *</label>
                        <input type="text" class="form-control @error('specialization') is-invalid @enderror" 
                               id="specialization" name="specialization" 
                               value="{{ old('specialization', $doctor->specialization) }}" required>
                        @error('specialization')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="available_from" class="form-label">Available From (Start Time) *</label>
                                <input type="time" class="form-control @error('available_from') is-invalid @enderror" 
                                       id="available_from" name="available_from" value="{{ old('available_from', $doctor->available_from) }}" required>
                                @error('available_from')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="available_to" class="form-label">Available To (End Time) *</label>
                                <input type="time" class="form-control @error('available_to') is-invalid @enderror" 
                                       id="available_to" name="available_to" value="{{ old('available_to', $doctor->available_to) }}" required>
                                @error('available_to')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Available Days *</label>
                        <div class="btn-group w-100" role="group">
                            @php
                                $selectedDays = json_decode($doctor->available_days ?? '[]', true) ?? [];
                            @endphp
                            @foreach(['Mon' => 'Monday', 'Tue' => 'Tuesday', 'Wed' => 'Wednesday', 'Thu' => 'Thursday', 'Fri' => 'Friday', 'Sat' => 'Saturday', 'Sun' => 'Sunday'] as $day => $label)
                                <input type="checkbox" class="btn-check" id="{{ $day }}" name="available_days[]" value="{{ $day }}" {{ in_array($day, old('available_days', $selectedDays)) ? 'checked' : '' }}>
                                <label class="btn btn-outline-primary" for="{{ $day }}">{{ $label }}</label>
                            @endforeach
                        </div>
                        @error('available_days')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description (Optional)</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="4">{{ old('description', $doctor->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Doctor
                        </button>
                        <a href="{{ route('doctors.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection