<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_doctors' => Doctor::count(),
            'total_patients' => User::where('role', 'patient')->count(),
            'pending_appointments' => Appointment::where('status', 'pending')->count(),
            'total_appointments' => Appointment::whereNotIn('status', ['cancelled'])->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    public function appointments()
    {
        // Don't show cancelled appointments
        $appointments = Appointment::with(['user', 'doctor'])
            ->whereNotIn('status', ['cancelled'])
            ->latest()
            ->paginate(15);
            
        return view('admin.appointments.index', compact('appointments'));
    }

    public function updateAppointmentStatus(Request $request, Appointment $appointment)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        // Don't allow changing cancelled appointments
        if ($appointment->status === 'cancelled') {
            return back()->with('error', 'Cannot change status of cancelled appointments.');
        }

        $appointment->update(['status' => $request->status]);

        return back()->with('success', 'Appointment status updated successfully!');
    }
}