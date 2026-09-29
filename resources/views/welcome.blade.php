<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Avoftbag - Protect Your Digital Gear</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800,900" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}?v=2">
</head>
<body class="antialiased bg-white text-gray-900 selection:bg-black selection:text-white">
    <!-- Navbar (Tomtoc style: Minimalist) -->
    <nav class="bg-white border-b border-gray-100 sticky top-0 z-50">
        <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Left Menu -->
                <div class="hidden md:flex space-x-8">
                    <a href="#produk" class="text-xs font-semibold text-gray-900 hover:text-gray-500 uppercase tracking-widest">Collections</a>
                    <a href="#" class="text-xs font-semibold text-gray-900 hover:text-gray-500 uppercase tracking-widest">About Us</a>
                </div>
                <!-- Center Logo -->
                <div class="flex-1 flex justify-center md:flex-none">
                    <a href="/" class="text-3xl font-black text-black tracking-tighter uppercase">
                        AVOFTBAG.
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

    @if(session('error'))
    <div class="bg-red-500 text-white text-center py-2 text-sm font-medium uppercase tracking-widest">
        {{ session('error') }}
    </div>
    @endif

    <!-- Hero Section (Full Width, Tomtoc vibe) -->
    <div class="relative w-full h-[85vh] bg-gray-900 flex items-center justify-center text-center">
        <!-- Background Image -->
        <img class="absolute inset-0 w-full h-full object-cover opacity-60" src="https://images.unsplash.com/photo-1553062407-98eeb64c6a62?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80" alt="Avoftbag Premium">
        <!-- Content -->
        <div class="relative z-10 px-4 sm:px-6 lg:px-8">
            <h1 class="text-5xl sm:text-6xl md:text-7xl font-black text-white tracking-tighter mb-4 uppercase">
                Protect<br/>Your Gear
            </h1>
            <p class="mt-6 max-w-2xl mx-auto text-lg sm:text-xl text-gray-300 font-light">
                Premium bag collections for mobility and maximum protection of your gadgets.
            </p>
            <div class="mt-10">
                <a href="#produk" class="inline-block bg-white text-black font-bold text-sm px-10 py-4 uppercase tracking-widest hover:bg-gray-200 transition duration-300">
                    Explore Now
                </a>
            </div>
        </div>
    </div>

    <!-- Features / Split Banners -->
    <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="relative h-[400px] bg-gray-100 group overflow-hidden">
                <img src="https://images.unsplash.com/photo-1544816155-12df9643f363?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition duration-700">
                <div class="absolute inset-0 bg-black/20"></div>
                <div class="absolute bottom-10 left-10">
                    <h3 class="text-3xl font-black text-white tracking-tighter uppercase mb-3">Everyday Series</h3>
                    <a href="#" class="text-white border-b-2 border-white pb-1 font-semibold hover:text-gray-200 uppercase tracking-widest text-xs">View Collection</a>
                </div>
            </div>
            <div class="relative h-[400px] bg-gray-100 group overflow-hidden">
                <img src="https://images.unsplash.com/photo-1584916201218-f4242ceb4809?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition duration-700">
                <div class="absolute inset-0 bg-black/20"></div>
                <div class="absolute bottom-10 left-10">
                    <h3 class="text-3xl font-black text-white tracking-tighter uppercase mb-3">Elegant Series</h3>
                    <a href="#" class="text-white border-b-2 border-white pb-1 font-semibold hover:text-gray-200 uppercase tracking-widest text-xs">View Collection</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Grid Section -->
    <section id="produk" class="py-20 border-t border-gray-100">
        <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end mb-12 gap-6">
                <div>
                    <h2 class="text-4xl font-black text-gray-900 uppercase tracking-tighter">
                        @if(request('search'))
                            Search Results for "{{ request('search') }}"
                        @else
                            Best Sellers
                        @endif
                    </h2>
                </div>
                
                <!-- Search Form -->
                <div class="w-full sm:w-auto">
                    <form action="{{ route('home') }}#produk" method="GET" class="relative flex">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..." class="w-full sm:w-64 border-b-2 border-black bg-transparent py-2 pl-2 pr-10 text-sm font-bold uppercase tracking-widest placeholder-gray-400 focus:outline-none focus:ring-0 focus:border-gray-500 transition">
                        <button type="submit" class="absolute right-0 top-1/2 -translate-y-1/2 p-2 text-black hover:text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

            @if($products->isEmpty())
                <div class="text-center py-20">
                    <h3 class="text-2xl font-bold text-gray-400 uppercase tracking-widest mb-4">No products found</h3>
                    <a href="{{ route('home') }}#produk" class="text-sm font-bold uppercase tracking-widest text-black border-b border-black pb-1 hover:text-gray-500">Clear Search</a>
                </div>
            @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-x-8 gap-y-12">
                @foreach ($products as $product)
                <div class="group relative flex flex-col">
                    <a href="{{ route('product.show', $product->id) }}" class="block relative w-full h-96 bg-gray-100 overflow-hidden mb-6">
                        <img src="{{ filter_var($product->image_path, FILTER_VALIDATE_URL) ? $product->image_path : ($product->image_path ? asset('storage/' . $product->image_path) : 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80') }}" alt="{{ $product->name }}" class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500">
                    </a>
                    <div class="flex-1 flex flex-col">
                        <h3 class="text-lg font-bold text-gray-900 mb-2 uppercase tracking-tight hover:text-gray-600 transition-colors">
                            <a href="{{ route('product.show', $product->id) }}">
                                {{ $product->name }}
                            </a>
                        </h3>
                        <p class="text-sm text-gray-500 mb-4 flex-1 line-clamp-2 leading-relaxed">{{ $product->description }}</p>
                        <p class="text-xl font-bold text-gray-900 mb-6">RM {{ number_format($product->price, 2) }}</p>
                    </div>
                    <div class="mt-auto">
                        <form action="{{ route('cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button type="submit" class="w-full bg-black text-white py-4 text-xs uppercase tracking-widest font-bold hover:bg-gray-800 transition duration-300 z-10 relative">
                                Add to Cart
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-black py-20">
        <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="text-3xl font-black text-white tracking-tighter uppercase mb-6">
                AVOFTBAG.
            </div>
            <p class="text-gray-400 text-base mb-10 font-light">Protecting your gadgets with style.</p>
            <p class="text-xs text-gray-600 uppercase tracking-widest font-semibold">
                &copy; {{ date('Y') }} Avoftbag Malaysia. All Rights Reserved.
            </p>
        </div>
    </footer>
</body>
</html>
