<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CareSync | Your Complete Health Partner</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .hero-bg {
            background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
        }
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
<body class="bg-white font-sans scroll-smooth">

    <nav class="bg-white/90 backdrop-blur-md sticky top-0 z-50 shadow-sm p-4 flex justify-between items-center px-6 md:px-20">
        <div class="text-2xl font-bold text-blue-600 flex items-center">
            <i class="fa-solid fa-hand-holding-medical mr-2 text-3xl"></i>Clinic Appointment
        </div>
        <div class="hidden md:flex space-x-8 font-medium text-gray-700">
            <a href="#" class="hover:text-blue-600 transition">Home</a>
            <a href="#services" class="hover:text-blue-600 transition">Services</a>
            <a href="#about" class="hover:text-blue-600 transition">About Us</a>
            <a href="#stats" class="hover:text-blue-600 transition">Impact</a>
        </div>
        <div class="flex gap-4">
            <a href="/login" class="px-6 py-2 border-2 border-blue-600 text-blue-600 rounded-full font-bold hover:bg-blue-600 hover:text-white transition duration-300">Login</a>
            <a href="/register" class="px-6 py-2 bg-blue-600 text-white rounded-full font-bold hover:bg-blue-700 transition duration-300 shadow-md">Register</a>
        </div>
    </nav>

    <header class="hero-bg h-[600px] flex items-center justify-center text-center text-white px-4">
        <div class="max-w-4xl">
            <span class="bg-blue-600/80 px-4 py-1 rounded-full text-sm uppercase tracking-widest mb-4 inline-block">24/7 Medical Support</span>
            <h1 class="text-4xl md:text-6xl font-extrabold mb-6 leading-tight">Advanced Healthcare <br>Made Simple.</h1>
            <p class="text-lg md:text-xl mb-10 text-gray-200">Skip the waiting room. Connect with top-rated doctors and manage your appointments digitally with CareSync's integrated platform.</p>
            <div class="flex flex-col md:flex-row justify-center gap-4">
                <a href="/register" class="bg-blue-600 hover:bg-blue-700 text-white px-10 py-4 rounded-lg text-lg font-bold transition flex items-center justify-center">
                    Book an Appointment <i class="fa-solid fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </header>

    <section id="stats" class="py-12 bg-blue-600 text-white">
        <div class="max-w-6xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div>
                <h3 class="text-4xl font-bold">50+</h3>
                <p class="text-blue-100">Specialist Doctors</p>
            </div>
            <div>
                <h3 class="text-4xl font-bold">10k+</h3>
                <p class="text-blue-100">Happy Patients</p>
            </div>
            <div>
                <h3 class="text-4xl font-bold">15+</h3>
                <p class="text-blue-100">Years Experience</p>
            </div>
            <div>
                <h3 class="text-4xl font-bold">100%</h3>
                <p class="text-blue-100">Secure Records</p>
            </div>
        </div>
    </section>

    <section id="services" class="py-24 px-6 md:px-20 bg-gray-50">
        <div class="text-center mb-16">
            <h2 class="text-blue-600 font-bold uppercase tracking-widest mb-2">Our Services</h2>
            <p class="text-4xl font-extrabold text-gray-800">What We Offer</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-xl transition group border-t-4 border-transparent hover:border-blue-600">
                <i class="fa-solid fa-heart-pulse text-4xl text-blue-600 mb-6 group-hover:scale-110 transition-transform"></i>
                <h3 class="text-2xl font-bold mb-4">Cardiology</h3>
                <p class="text-gray-600">Comprehensive heart care, from routine checkups to specialized diagnostics.</p>
            </div>
            <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-xl transition group border-t-4 border-transparent hover:border-blue-600">
                <i class="fa-solid fa-brain text-4xl text-blue-600 mb-6 group-hover:scale-110 transition-transform"></i>
                <h3 class="text-2xl font-bold mb-4">Neurology</h3>
                <p class="text-gray-600">Expert diagnosis and treatment for all neurological conditions.</p>
            </div>
            <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-xl transition group border-t-4 border-transparent hover:border-blue-600">
                <i class="fa-solid fa-child text-4xl text-blue-600 mb-6 group-hover:scale-110 transition-transform"></i>
                <h3 class="text-2xl font-bold mb-4">Pediatrics</h3>
                <p class="text-gray-600">Specialized medical care for infants, children, and adolescents.</p>
            </div>
        </div>
    </section>

    <section id="about" class="py-24 px-6 md:px-20 flex flex-col md:flex-row items-center gap-16">
        <div class="w-full md:w-1/2">
            <img src="https://images.unsplash.com/photo-1581056771107-24ca5f033842?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="About Clinic" class="rounded-3xl shadow-2xl">
        </div>
        <div class="w-full md:w-1/2">
            <h2 class="text-blue-600 font-bold uppercase mb-2">Why Choose Us</h2>
            <h3 class="text-4xl font-extrabold text-gray-800 mb-6">Experience High-Quality Medical Care</h3>
            <p class="text-gray-600 text-lg mb-8 leading-relaxed">
                We believe that healthcare should be accessible, efficient, and compassionate. Our system connects patients with the best medical professionals in the city, ensuring you get the care you deserve without the stress of long queues.
            </p>
            <ul class="space-y-4">
                <li class="flex items-center text-gray-700 font-medium italic"><i class="fa-solid fa-check-circle text-blue-600 mr-3 text-xl"></i> Verified Specialist Doctors</li>
                <li class="flex items-center text-gray-700 font-medium italic"><i class="fa-solid fa-check-circle text-blue-600 mr-3 text-xl"></i> Real-time Appointment Scheduling</li>
                <li class="flex items-center text-gray-700 font-medium italic"><i class="fa-solid fa-check-circle text-blue-600 mr-3 text-xl"></i> Complete Medical History Tracking</li>
            </ul>
        </div>
    </section>

    <section class="py-20 bg-gray-900 text-white text-center">
        <h2 class="text-4xl font-bold mb-6">Ready to Experience Modern Healthcare?</h2>
        <p class="text-gray-400 mb-10 max-w-xl mx-auto">Whether you are a patient looking for care or a medical professional, join our community today.</p>
        <div class="flex justify-center gap-6">
            <a href="/login" class="bg-blue-600 hover:bg-blue-700 px-10 py-4 rounded-full font-bold transition shadow-lg">Access Your Dashboard</a>
        </div>
    </section>
<footer class="text-center">
        <div class="container">
            <p class="mb-0">&copy; {{ date('Y') }} Clinic Appointment System. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>