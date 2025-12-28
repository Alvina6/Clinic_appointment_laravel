<?php

namespace App\Http\Controllers;
use App\Models\Doctor;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AppointmentsController extends Controller
{
    public function index()
    {
        $doctors = Doctor::all();
        return view('patient.appointments.index', compact('doctors'));
    }

    public function create(Doctor $doctor)
    {
        return view('patient.appointments.create', compact('doctor'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required',
            'reason' => 'nullable|string|max:500',
        ]);

        $doctor = Doctor::findOrFail($request->doctor_id);
        $appointmentDate = $request->appointment_date;
        $appointmentTime = $request->appointment_time;

        // 1. Check if slot is already booked
        $isBooked = Appointment::where('doctor_id', $request->doctor_id)
            ->where('appointment_date', $appointmentDate)
            ->where('appointment_time', $appointmentTime)
            ->whereIn('status', ['pending', 'approved'])
            ->exists();

        if ($isBooked) {
            return back()
                ->withErrors(['appointment_time' => 'This time slot is already booked. Please choose another time.'])
                ->withInput();
        }

        // 2. Check if time is within doctor's available hours
        if ($appointmentTime < $doctor->available_from || $appointmentTime > $doctor->available_to) {
            return back()
                ->withErrors(['appointment_time' => 'Doctor is not available at this time. Available hours: ' . $doctor->available_from . ' - ' . $doctor->available_to])
                ->withInput();
        }

        // 3. Check if appointment day is in doctor's available days
        $selectedDate = Carbon::parse($appointmentDate);
        $dayOfWeek = $selectedDate->format('D'); // Mon, Tue, Wed, etc.
        
        $availableDays = json_decode($doctor->available_days, true) ?? [];
        
        if (!in_array($dayOfWeek, $availableDays)) {
            $dayNames = [
                'Mon' => 'Monday',
                'Tue' => 'Tuesday', 
                'Wed' => 'Wednesday',
                'Thu' => 'Thursday',
                'Fri' => 'Friday',
                'Sat' => 'Saturday',
                'Sun' => 'Sunday'
            ];
            
            $availableDayNames = array_map(function($day) use ($dayNames) {
                return $dayNames[$day] ?? $day;
            }, $availableDays);
            
            return back()
                ->withErrors(['appointment_date' => 'Doctor is not available on ' . $dayNames[$dayOfWeek] . '. Available days: ' . implode(', ', $availableDayNames)])
                ->withInput();
        }

        // 4. All validations passed - create appointment
        Appointment::create([
            'user_id' => Auth::id(),
            'doctor_id' => $request->doctor_id,
            'appointment_date' => $appointmentDate,
            'appointment_time' => $appointmentTime,
            'status' => 'pending',
            'reason' => $request->reason,
        ]);

        return redirect()
            ->route('patient.appointments.history')
            ->with('success', 'Appointment booked successfully! Waiting for admin approval.');
    }

    public function history()
    {
        $appointments = Appointment::with('doctor')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('patient.appointments.history', compact('appointments'));
    }

    public function cancel($appointmentId)
    {
        $appointment = Appointment::where('id', $appointmentId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Check if appointment can be cancelled
        if (in_array($appointment->status, ['completed', 'cancelled'])) {
            return back()->with('error', 'This appointment cannot be cancelled.');
        }

        // Cancel the appointment
        $appointment->update(['status' => 'cancelled']);

        return back()->with('success', 'Appointment cancelled successfully.');
    }

    public function reschedule($appointmentId)
    {
        $appointment = Appointment::where('id', $appointmentId)
            ->where('user_id', Auth::id())
            ->with('doctor')
            ->firstOrFail();

        // Only pending appointments can be rescheduled
        if ($appointment->status !== 'pending') {
            return back()->with('error', 'Only pending appointments can be rescheduled.');
        }

        return view('patient.appointments.reschedule', compact('appointment'));
    }

    public function updateReschedule(Request $request, $appointmentId)
    {
        $appointment = Appointment::where('id', $appointmentId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Only pending appointments can be rescheduled
        if ($appointment->status !== 'pending') {
            return back()->with('error', 'Only pending appointments can be rescheduled.');
        }

        $request->validate([
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required',
            'reason' => 'nullable|string|max:500',
        ]);

        $doctor = $appointment->doctor;
        $appointmentDate = $request->appointment_date;
        $appointmentTime = $request->appointment_time;

        // 1. Check if slot is already booked (excluding current appointment)
        $isBooked = Appointment::where('doctor_id', $doctor->id)
            ->where('id', '!=', $appointmentId)
            ->where('appointment_date', $appointmentDate)
            ->where('appointment_time', $appointmentTime)
            ->whereIn('status', ['pending', 'approved'])
            ->exists();

        if ($isBooked) {
            return back()
                ->withErrors(['appointment_time' => 'This time slot is already booked. Please choose another time.'])
                ->withInput();
        }

        // 2. Check if time is within doctor's available hours
        if ($appointmentTime < $doctor->available_from || $appointmentTime > $doctor->available_to) {
            return back()
                ->withErrors(['appointment_time' => 'Doctor is not available at this time. Available hours: ' . $doctor->available_from . ' - ' . $doctor->available_to])
                ->withInput();
        }

        // 3. Check if appointment day is in doctor's available days
        $selectedDate = Carbon::parse($appointmentDate);
        $dayOfWeek = $selectedDate->format('D');
        
        $availableDays = json_decode($doctor->available_days, true) ?? [];
        
        if (!in_array($dayOfWeek, $availableDays)) {
            $dayNames = [
                'Mon' => 'Monday',
                'Tue' => 'Tuesday', 
                'Wed' => 'Wednesday',
                'Thu' => 'Thursday',
                'Fri' => 'Friday',
                'Sat' => 'Saturday',
                'Sun' => 'Sunday'
            ];
            
            return back()
                ->withErrors(['appointment_date' => 'Doctor is not available on ' . $dayNames[$dayOfWeek] . '.'])
                ->withInput();
        }

        // Update appointment
        $appointment->update([
            'appointment_date' => $appointmentDate,
            'appointment_time' => $appointmentTime,
            'reason' => $request->reason ?? $appointment->reason,
        ]);

        return redirect()
            ->route('patient.appointments.history')
            ->with('success', 'Appointment rescheduled successfully!');
    }
}