@extends('layouts.layout')

@section('title', 'Patient Registration - CareSync')

@section('content')
<div class="flex items-center justify-center min-h-[90vh] py-12 px-4 bg-gray-50">
    <div class="bg-white shadow-2xl rounded-3xl flex flex-col md:flex-row max-w-5xl w-full overflow-hidden border border-gray-100">
        
        <div class="hidden md:flex md:w-2/5 bg-gradient-to-br from-blue-600 to-blue-800 p-12 text-white flex-col justify-between">
            <div>
                <h2 class="text-4xl font-extrabold leading-tight mb-6">Join Our Healthcare Community</h2>
                <p class="text-blue-100 text-lg mb-8 italic">"The greatest wealth is health. Take the first step towards a better life today."</p>
                
                <ul class="space-y-4">
                    <li class="flex items-center"><i class="fa-solid fa-circle-check mr-3"></i> Quick Appointment Booking</li>
                    <li class="flex items-center"><i class="fa-solid fa-circle-check mr-3"></i> Access to Top Specialists</li>
                    <!-- <li class="flex items-center"><i class="fa-solid fa-circle-check mr-3"></i> Digital Prescription History</li> -->
                </ul>
            </div>
            <div class="opacity-50 text-sm italic">
                &copy; 2025 CareSync Secure Patient Portal
            </div>
        </div>

        <div class="w-full md:w-3/5 p-8 md:p-14">
            <div class="mb-10 text-center md:text-left">
                <h3 class="text-3xl font-bold text-gray-800">Create Account</h3>
                <p class="text-gray-500 mt-2 font-medium">Register as a patient to start booking appointments.</p>
            </div>

            <form action="{{ route('register') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @csrf
                
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Full Name</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <i class="fa-solid fa-user"></i>
                        </span>
                        <input type="text" name="name" required class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-600 outline-none transition" placeholder="John Doe">
                    </div>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <i class="fa-solid fa-envelope"></i>
                        </span>
                        <input type="email" name="email" required class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-600 outline-none transition" placeholder="john@example.com">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Phone Number</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <i class="fa-solid fa-phone"></i>
                        </span>
                        <input type="text" name="phone" required class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-600 outline-none transition" placeholder="03001234567">
                    </div>
                </div>
<br>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <i class="fa-solid fa-lock"></i>
                        </span>
                        <input type="password" name="password" required class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-600 outline-none transition" placeholder="••••••••">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Confirm Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <i class="fa-solid fa-shield-halved"></i>
                        </span>
                        <input type="password" name="password_confirmation" required class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-600 outline-none transition" placeholder="••••••••">
                    </div>
                </div>

                <div class="md:col-span-2 pt-4">
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-xl shadow-lg shadow-blue-200 transition-all transform hover:-translate-y-1">
                        Create My Account
                    </button>
                </div>

                <div class="md:col-span-2 text-center mt-4">
                    <p class="text-gray-600">Already registered? <a href="/login" class="text-blue-600 font-bold hover:underline">Login here</a></p>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection