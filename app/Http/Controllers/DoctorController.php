<?php

namespace App\Http\Controllers;
use App\Models\Doctor;
use App\Models\Appointment;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::all();
        return view('admin.doctors.index', compact('doctors'));
    }

    public function create()
    {
        return view('admin.doctors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:doctors,email',
            'password' => 'required|min:6',
            'specialization' => 'required|string|max:255',
            'available_from' => 'required|date_format:H:i',
            'available_to' => 'required|date_format:H:i',
            'available_days' => 'required|array',
            'description' => 'nullable|string',
        ]);

        // Check if available_to is after available_from (time comparison)
        if (strtotime($request->available_to) <= strtotime($request->available_from)) {
            return back()->withErrors(['available_to' => 'End time must be after start time.'])->withInput();
        }

        Doctor::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'specialization' => $request->specialization,
            'available_from' => $request->available_from,
            'available_to' => $request->available_to,
            'available_days' => json_encode($request->available_days),
            'description' => $request->description,
        ]);

        return redirect()
            ->route('doctors.index')
            ->with('success', 'Doctor created successfully!');
    }

    public function edit(Doctor $doctor)
    {
        return view('admin.doctors.edit', compact('doctor'));
    }

    public function update(Request $request, Doctor $doctor)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:doctors,email,' . $doctor->id,
            'password' => 'nullable|min:6',
            'specialization' => 'required|string|max:255',
            'available_from' => 'required|date_format:H:i',
            'available_to' => 'required|date_format:H:i',
            'available_days' => 'required|array',
            'description' => 'nullable|string',
        ]);

        // Check if available_to is after available_from (time comparison)
        if (strtotime($request->available_to) <= strtotime($request->available_from)) {
            return back()->withErrors(['available_to' => 'End time must be after start time.'])->withInput();
        }

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'specialization' => $request->specialization,
            'available_from' => $request->available_from,
            'available_to' => $request->available_to,
            'available_days' => json_encode($request->available_days),
            'description' => $request->description,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $doctor->update($data);

        return redirect()
            ->route('doctors.index')
            ->with('success', 'Doctor updated successfully!');
    }

    public function destroy(Doctor $doctor)
    {
        $doctor->delete();
        return redirect()->route('doctors.index')->with('success', 'Doctor deleted successfully!');
    }

    public function show(Doctor $doctor)
    {
        return view('admin.doctors.show', compact('doctor'));
    }

    public function doctorDashboard()
    {
        $doctorSession = session('doctor');
        if (!$doctorSession) {
            return redirect()->route('login')->with('error', 'Please login first');
        }

        $doctor = Doctor::findOrFail($doctorSession['id']);

        // Don't show cancelled appointments
        $appointments = $doctor->appointments()
            ->whereNotIn('status', ['cancelled'])
            ->latest()
            ->paginate(10);
        
        return view('doctor.dashboard', [
            'doctor' => $doctor,
            'appointments' => $appointments,
            'totalAppointments' => $doctor->appointments()->whereNotIn('status', ['cancelled'])->count(),
            'completedAppointments' => $doctor->appointments()->where('status', 'completed')->count(),
            'pendingAppointments' => $doctor->appointments()->where('status', 'pending')->count(),
        ]);
    }

    public function doctorAppointments()
    {
        $doctorSession = session('doctor');
        if (!$doctorSession) {
            return redirect()->route('login')->with('error', 'Please login first');
        }

        $doctor = Doctor::findOrFail($doctorSession['id']);

        // Don't show cancelled appointments
        $appointments = $doctor->appointments()
            ->whereNotIn('status', ['cancelled'])
            ->latest()
            ->paginate(15);
        
        return view('doctor.appointments', [
            'doctor' => $doctor,
            'appointments' => $appointments,
        ]);
    }

    public function updateDoctorAppointmentStatus($appointmentId, Request $request)
    {
        $doctorSession = session('doctor');
        if (!$doctorSession) {
            return redirect()->route('login')->with('error', 'Please login first');
        }

        $doctor = Doctor::findOrFail($doctorSession['id']);

        $appointment = $doctor->appointments()->find($appointmentId);

        if (!$appointment) {
            return back()->with('error', 'Appointment not found.');
        }

        // Don't allow changing completed or cancelled appointments
        if (in_array($appointment->status, ['completed', 'cancelled'])) {
            return back()->with('error', 'Cannot change status of completed or cancelled appointments.');
        }

        $request->validate([
            'status' => 'required|in:pending,completed,cancelled',
        ]);

        $appointment->update(['status' => $request->status]);

        return back()->with('success', 'Appointment status updated successfully!');
    }
}