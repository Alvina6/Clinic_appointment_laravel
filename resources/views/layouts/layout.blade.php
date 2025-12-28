<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CareSync')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    @yield('styles')
    <style>
        footer {
            background-color: #343a40;
            color: white;
            padding: 1rem 0;
            margin-top: auto;
        }
        .alert {
            border-radius: 0.5rem;
        }
        .badge {
            padding: 0.5em 0.75em;
        }
    </style>
</head>
<body class="bg-gray-50 font-sans scroll-smooth">

    <nav class="bg-white/90 backdrop-blur-md sticky top-0 z-50 shadow-sm p-4 flex justify-between items-center px-6 md:px-20">
        <div class="text-2xl font-bold text-blue-600 flex items-center">
            <a href="/" class="flex items-center">
                <i class="fa-solid fa-hand-holding-medical mr-2 text-3xl"></i> Clinic Appointment
            </a>
        </div>
        <div class="hidden md:flex space-x-8 font-medium text-gray-700">
            <a href="/" class="hover:text-blue-600 transition">Home</a>
            <a href="/#services" class="hover:text-blue-600 transition">Services</a>
            <a href="/#about" class="hover:text-blue-600 transition">About</a>
        </div>
        <div class="flex gap-4 items-center">
            @if(Auth::check() || session('doctor_id'))
                <a href="/logout" class="text-red-500 font-bold">Logout</a>
            @else
                <a href="/login" class="text-blue-600 font-bold">Login</a>
                <a href="/register" class="bg-blue-600 text-white px-6 py-2 rounded-full font-bold hover:bg-blue-700 transition shadow-md">Register</a>
            @endif
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="text-center">
        <div class="container">
            <p class="mb-0">&copy; {{ date('Y') }} Clinic Appointment System. All rights reserved.</p>
        </div>
    </footer>

    @yield('scripts')
</body>
</html>