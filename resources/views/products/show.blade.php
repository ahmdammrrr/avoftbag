<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $product->name }} | AVOFTBAG</title>
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
    <!-- Navbar -->
    <nav class="bg-white border-b border-gray-100 sticky top-0 z-50">
        <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Left Menu -->
                <div class="hidden md:flex space-x-8">
                    <a href="{{ route('home') }}#produk" class="text-xs font-semibold text-gray-900 hover:text-gray-500 uppercase tracking-widest">Collections</a>
                    <a href="#" class="text-xs font-semibold text-gray-900 hover:text-gray-500 uppercase tracking-widest">About Us</a>
                </div>
                <!-- Center Logo -->
                <div class="flex-1 flex justify-center md:flex-none">
                    <a href="{{ route('home') }}" class="text-3xl font-black text-black tracking-tighter uppercase">
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

    <!-- Product Details Section -->
    <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24">
        <div class="flex flex-col lg:flex-row gap-16">
            <!-- Product Image -->
            <div class="w-full lg:w-1/2">
                <div class="bg-gray-50 aspect-square flex items-center justify-center p-8 overflow-hidden group">
                    <img src="{{ filter_var($product->image_path, FILTER_VALIDATE_URL) ? $product->image_path : ($product->image_path ? asset('storage/' . $product->image_path) : 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80') }}" 
                         alt="{{ $product->name }}" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                </div>
            </div>

            <!-- Product Info -->
            <div class="w-full lg:w-1/2 flex flex-col justify-center">
                <!-- Breadcrumbs -->
                <nav class="flex text-xs font-bold uppercase tracking-widest text-gray-400 mb-6" aria-label="Breadcrumb">
                    <a href="{{ route('home') }}" class="hover:text-black transition">Home</a>
                    <span class="mx-2">/</span>
                    <a href="{{ route('home') }}#produk" class="hover:text-black transition">Products</a>
                    <span class="mx-2">/</span>
                    <span class="text-black">{{ $product->name }}</span>
                </nav>

                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-black tracking-tighter uppercase mb-4">
                    {{ $product->name }}
                </h1>
                
                <p class="text-2xl sm:text-3xl font-bold text-black mb-8">
                    RM {{ number_format($product->price, 2) }}
                </p>

                <div class="prose prose-sm sm:prose-base prose-gray max-w-none text-gray-600 mb-10 leading-relaxed font-medium">
                    <p>{{ $product->description }}</p>
                </div>

                <!-- Stock info & Add to Cart -->
                <div class="mt-auto border-t border-gray-200 pt-8">
                    @if($product->stock > 0)
                        <p class="text-xs font-bold uppercase tracking-widest text-green-600 mb-4 flex items-center">
                            <span class="w-2 h-2 rounded-full bg-green-500 mr-2"></span>
                            In Stock ({{ $product->stock }} available)
                        </p>
                        
                        <form action="{{ route('cart.add') }}" method="POST" class="flex gap-4">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            
                            <!-- Qty input -->
                            <div class="flex border-2 border-black w-32 h-14 items-center justify-between px-4 shrink-0">
                                <button type="button" onclick="document.getElementById('qty').value = Math.max(1, parseInt(document.getElementById('qty').value) - 1)" class="text-black font-bold text-xl hover:text-gray-500 pb-1">&minus;</button>
                                <input type="number" id="qty" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="w-12 text-center text-lg font-bold border-none focus:ring-0 p-0" style="-moz-appearance: textfield;">
                                <button type="button" onclick="document.getElementById('qty').value = Math.min({{ $product->stock }}, parseInt(document.getElementById('qty').value) + 1)" class="text-black font-bold text-xl hover:text-gray-500 pb-1">&plus;</button>
                            </div>

                            <button type="submit" class="w-full bg-black text-white h-14 text-sm uppercase tracking-widest font-bold hover:bg-gray-800 transition duration-300 flex-1">
                                Add to Cart
                            </button>
                        </form>
                    @else
                        <p class="text-xs font-bold uppercase tracking-widest text-red-600 mb-4 flex items-center">
                            <span class="w-2 h-2 rounded-full bg-red-500 mr-2"></span>
                            Out of Stock
                        </p>
                        <button disabled class="w-full bg-gray-200 text-gray-500 h-14 text-sm uppercase tracking-widest font-bold cursor-not-allowed">
                            Currently Unavailable
                        </button>
                    @endif
                </div>

                <!-- Delivery Info Accordion -->
                <div class="mt-12 space-y-4 border-t border-gray-200 pt-8">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-black mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                        <div>
                            <h4 class="text-sm font-bold uppercase tracking-widest text-black mb-1">Premium Quality Guaranteed</h4>
                            <p class="text-xs text-gray-500 font-medium">Built with water-resistant materials and military-grade padding.</p>
                        </div>
                    </div>
                    <div class="flex items-start pt-4 border-t border-gray-100">
                        <svg class="w-6 h-6 text-black mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <div>
                            <h4 class="text-sm font-bold uppercase tracking-widest text-black mb-1">Fast Delivery</h4>
                            <p class="text-xs text-gray-500 font-medium">Ships within 24 hours. Express options available at checkout.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
    <section class="py-20 border-t border-gray-100 bg-gray-50">
        <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-12 text-center">
                <h2 class="text-3xl font-black text-gray-900 uppercase tracking-tighter">You May Also Like</h2>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-x-8 gap-y-12">
                @foreach ($relatedProducts as $item)
                <div class="group relative flex flex-col bg-white border border-gray-100 hover:border-gray-300 transition-colors p-4">
                    <a href="{{ route('product.show', $item->id) }}" class="absolute inset-0 z-10"></a>
                    <div class="relative w-full h-64 bg-gray-100 overflow-hidden mb-6">
                        <img src="{{ filter_var($item->image_path, FILTER_VALIDATE_URL) ? $item->image_path : ($item->image_path ? asset('storage/' . $item->image_path) : 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80') }}" 
                             alt="{{ $item->name }}" 
                             class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500">
                    </div>
                    <h3 class="text-sm font-bold text-gray-900 mb-1 uppercase tracking-tight truncate">
                        {{ $item->name }}
                    </h3>
                    <p class="text-lg font-bold text-black mt-auto">RM {{ number_format($item->price, 2) }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

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
    
    <style>
        /* Hide number input arrows */
        input[type="number"]::-webkit-inner-spin-button, 
        input[type="number"]::-webkit-outer-spin-button { 
            -webkit-appearance: none; 
            margin: 0; 
        }
    </style>
</body>
</html>
