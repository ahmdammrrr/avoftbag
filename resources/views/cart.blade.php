<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cart - Aerobag</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800,900" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="antialiased bg-white text-gray-900 selection:bg-black selection:text-white">
    <!-- Navbar (Tomtoc style: Minimalist) -->
    <nav class="bg-white border-b border-gray-100 sticky top-0 z-50">
        <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Left Menu -->
                <div class="hidden md:flex space-x-8">
                    <a href="/#produk" class="text-xs font-semibold text-gray-900 hover:text-gray-500 uppercase tracking-widest">Collections</a>
                    <a href="/#" class="text-xs font-semibold text-gray-900 hover:text-gray-500 uppercase tracking-widest">About Us</a>
                </div>
                <!-- Center Logo -->
                <div class="flex-1 flex justify-center md:flex-none">
                    <a href="/" class="text-3xl font-black text-black tracking-tighter uppercase">
                        AEROBAG.
                    </a>
                </div>
                <!-- Right Icons -->
                <div class="flex items-center space-x-6">
                    <a href="{{ route('cart.index') }}" class="text-black hover:text-gray-600 transition flex items-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        @php $cartCount = session('cart') ? count(session('cart')) : 0; @endphp
                        <span class="ml-1 text-sm font-medium hidden sm:block">({{ $cartCount }})</span>
                    </a>
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-xs font-semibold text-black hover:text-gray-600 uppercase tracking-widest">Account</a>
                        @else
                            <a href="{{ route('login') }}" class="text-xs font-semibold text-black hover:text-gray-600 uppercase tracking-widest">Login</a>
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Message -->
    @if(session('success'))
    <div class="bg-green-500 text-white text-center py-2 text-sm font-medium uppercase tracking-widest">
        {{ session('success') }}
    </div>
    @endif

    <!-- Cart Section -->
    <main class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 py-16 min-h-[60vh]">
        <h1 class="text-4xl font-black text-gray-900 uppercase tracking-tighter mb-10">Your Cart</h1>

        @if(count($cart) > 0)
        <div class="flex flex-col lg:flex-row gap-12">
            <!-- Cart Items -->
            <div class="lg:w-2/3">
                <div class="border-t border-gray-200">
                    @foreach($cart as $id => $details)
                    <div class="flex items-center py-6 border-b border-gray-200">
                        <div class="h-24 w-24 flex-shrink-0 overflow-hidden rounded-md border border-gray-200">
                            <img src="{{ filter_var($details['image_path'], FILTER_VALIDATE_URL) ? $details['image_path'] : ($details['image_path'] ? asset('storage/' . $details['image_path']) : 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80') }}" alt="{{ $details['name'] }}" class="h-full w-full object-cover object-center">
                        </div>
                        <div class="ml-4 flex flex-1 flex-col">
                            <div>
                                <div class="flex justify-between text-base font-bold text-gray-900 uppercase">
                                    <h3>{{ $details['name'] }}</h3>
                                    <p class="ml-4">RM {{ number_format($details['price'] * $details['quantity'], 2) }}</p>
                                </div>
                                <p class="mt-1 text-sm text-gray-500">RM {{ number_format($details['price'], 2) }} each</p>
                            </div>
                            <div class="flex flex-1 items-end justify-between text-sm">
                                <p class="text-gray-500 font-medium">Qty: {{ $details['quantity'] }}</p>

                                <div class="flex">
                                    <form action="{{ route('cart.remove') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $id }}">
                                        <button type="submit" class="font-medium text-red-600 hover:text-red-500 uppercase tracking-widest text-xs">Remove</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Order Summary -->
            <div class="lg:w-1/3">
                <div class="bg-gray-50 p-6 rounded-lg border border-gray-100">
                    <h2 class="text-lg font-bold text-gray-900 uppercase tracking-widest mb-4">Order Summary</h2>
                    <div class="flex justify-between text-base font-medium text-gray-900 mb-4">
                        <p>Subtotal</p>
                        <p>RM {{ number_format($total, 2) }}</p>
                    </div>
                    <p class="text-sm text-gray-500 mb-6 leading-relaxed">Shipping and taxes calculated at checkout.</p>
                    <div class="mt-6">
                        <a href="{{ route('dashboard') }}" class="flex items-center justify-center w-full bg-black px-6 py-4 text-sm font-bold text-white shadow-sm hover:bg-gray-800 uppercase tracking-widest transition duration-300">
                            Checkout
                        </a>
                    </div>
                    <div class="mt-6 flex justify-center text-center text-sm text-gray-500">
                        <p>
                            or
                            <a href="/" class="font-medium text-black underline hover:text-gray-600 ml-1">
                                Continue Shopping
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="text-center py-16">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
            </svg>
            <h3 class="mt-2 text-sm font-semibold text-gray-900 uppercase tracking-widest">Cart is empty</h3>
            <p class="mt-1 text-sm text-gray-500">Start shopping to add items to your cart.</p>
            <div class="mt-6">
                <a href="/#produk" class="inline-flex items-center bg-black px-8 py-4 text-sm font-bold text-white hover:bg-gray-800 uppercase tracking-widest transition duration-300">
                    Explore Collections
                </a>
            </div>
        </div>
        @endif
    </main>

    <!-- Footer -->
    <footer class="bg-black py-20">
        <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="text-3xl font-black text-white tracking-tighter uppercase mb-6">
                AEROBAG.
            </div>
            <p class="text-gray-400 text-base mb-10 font-light">Protecting your gadgets with style.</p>
            <p class="text-xs text-gray-600 uppercase tracking-widest font-semibold">
                &copy; {{ date('Y') }} Aerobag Malaysia. All Rights Reserved.
            </p>
        </div>
    </footer>
</body>
</html>
