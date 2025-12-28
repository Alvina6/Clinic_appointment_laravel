<?php

namespace App\Http\Controllers;
use App\Models\Doctor;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function dashboard()
    {
        $patient_id = auth()->id();
        
        // Stats calculation
        $total_appointments = \App\Models\Appointment::where('user_id', $patient_id)->count();
        $pending_appointments = \App\Models\Appointment::where('user_id', $patient_id)->where('status', 'pending')->count();
        $completed_appointments = \App\Models\Appointment::where('user_id', $patient_id)->where('status', 'approved')->count();

        // Data for UI
        $doctors = Doctor::take(6)->get();
        $recent_appointments = \App\Models\Appointment::where('user_id', $patient_id)
                                ->with('doctor')
                                ->latest()
                                ->take(4)
                                ->get();

        return view('patient.dashboard', compact(
            'doctors', 'total_appointments', 'pending_appointments', 'completed_appointments', 'recent_appointments'
        ));
    }
}