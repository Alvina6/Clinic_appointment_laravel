<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Doctor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

class AuthController extends Controller
{
     public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

     public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

         $email = $request->email;
        $password = $request->password;

        // Try to find user (Admin or Patient)
        $user = User::where('email', $email)->first();

        if ($user) {
            // For admin, check plain text password (exact match)
            if ($user->isAdmin() && $password === $user->password) {
                Auth::login($user);
                $request->session()->regenerate();
                return redirect()->route('dashboard')->with('success', 'Login successful!');
            }
            
            // For patient, check hashed password
            if (!$user->isAdmin() && Hash::check($password, $user->password)) {
                Auth::login($user);
                $request->session()->regenerate();
                return redirect()->route('dashboard')->with('success', 'Login successful!');
            }
        }

        // Try to find doctor
        $doctor = Doctor::where('email', $email)->first();

        if ($doctor && Hash::check($password, $doctor->password)) {
            // Store doctor in session
            $request->session()->put('doctor', [
                'id' => $doctor->id,
                'name' => $doctor->name,
                'email' => $doctor->email,
                'specialization' => $doctor->specialization,
            ]);
            $request->session()->regenerate();
            return redirect()->route('doctor.dashboard')->with('success', 'Login successful!');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($request->only('email'));
    }

    public function showRegistrationForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:15',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Registration successful!');
    }

    public function logout(Request $request)
    {
         if (Auth::check()) {
            Auth::logout();
        }

        // Logout doctor
        if ($request->session()->has('doctor')) {
            $request->session()->forget('doctor');
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Logged out successfully!');
    }
}
