@extends('layouts.layout')

@section('title', 'Login - CareSync')

@section('content')
<div class="flex items-center justify-center min-h-[80vh] py-12 px-4">
    <div class="bg-white shadow-2xl rounded-3xl flex flex-col md:flex-row max-w-4xl w-full overflow-hidden border border-gray-100">
        
        <div class="hidden md:flex md:w-1/2 bg-blue-600 p-12 text-white flex-col justify-center">
            <h2 class="text-4xl font-extrabold leading-tight mb-4">Welcome Back!</h2>
            <p class="text-blue-100 mb-6">Access your appointments, medical records, and doctor schedules in one click.</p>
            <i class="fa-solid fa-user-shield text-8xl opacity-20 self-center mt-4"></i>
        </div>

        <div class="w-full md:w-1/2 p-8 md:p-16">
            <h3 class="text-3xl font-bold text-gray-800 mb-6 text-center">Login</h3>
            <form action="{{ route('login') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                    <input type="email" name="email" required class="w-full px-4 py-3 border rounded-xl outline-none focus:ring-2 focus:ring-blue-600 border-gray-200">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                    <input type="password" name="password" required class="w-full px-4 py-3 border rounded-xl outline-none focus:ring-2 focus:ring-blue-600 border-gray-200">
                </div>
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl transition-all shadow-lg shadow-blue-200">
                    Sign In
                </button>
            </form>
            <p class="text-center mt-8 text-gray-600">New patient? <a href="/register" class="text-blue-600 font-bold">Register here</a></p>
        </div>
    </div>
</div>
@endsection