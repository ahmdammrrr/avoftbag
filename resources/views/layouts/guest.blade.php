<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AVOFTBAG - Authentication</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800,900" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="font-sans text-gray-900 antialiased bg-white selection:bg-black selection:text-white">
    <div class="flex min-h-screen">
        <!-- Left Side Image -->
        <div class="hidden lg:flex lg:w-1/2 relative bg-gray-900">
            <img src="https://images.unsplash.com/photo-1553062407-98eeb64c6a62?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" alt="Avoftbag Premium" class="absolute inset-0 w-full h-full object-cover opacity-70">
            <div class="absolute inset-0 flex flex-col justify-between p-12 z-10">
                <a href="/" class="text-4xl font-black text-white tracking-tighter uppercase hover:opacity-80 transition">
                    AVOFTBAG.
                </a>
                <div>
                    <h1 class="text-5xl font-black text-white uppercase tracking-tighter mb-4">Protect<br/>Your Gear.</h1>
                    <p class="text-gray-300 text-lg font-light max-w-md">Join us to experience premium mobility and protection for your essential gadgets.</p>
                </div>
            </div>
        </div>
        
        <!-- Right Side Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 sm:p-12 lg:p-24 bg-white">
            <div class="w-full max-w-sm">
                <div class="lg:hidden mb-12 text-center">
                    <a href="/" class="text-4xl font-black text-black tracking-tighter uppercase">
                        AVOFTBAG.
                    </a>
                </div>
                
                {{ $slot }}
                
            </div>
        </div>
    </div>
</body>
</html>
