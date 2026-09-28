<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-white min-h-[60vh]">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative shadow-sm">
                {{ session('success') }}
            </div>
            @endif

            <div class="mb-8 flex justify-between items-center">
                <h3 class="text-2xl font-black uppercase tracking-tighter border-b-2 border-black inline-block pb-1">Manage Products</h3>
                <div class="flex gap-4">
                    <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-black font-bold uppercase tracking-widest text-sm flex items-center transition">
                        &larr; Back to Orders
                    </a>
                    <a href="{{ route('admin.products.create') }}" class="bg-black text-white px-6 py-3 text-sm font-bold uppercase tracking-widest hover:bg-gray-800 transition duration-300">
                        + Add New Product
                    </a>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm border border-gray-200">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left font-bold text-gray-500 uppercase tracking-widest">Image</th>
                                <th class="px-6 py-4 text-left font-bold text-gray-500 uppercase tracking-widest">Name</th>
                                <th class="px-6 py-4 text-left font-bold text-gray-500 uppercase tracking-widest">Price</th>
                                <th class="px-6 py-4 text-left font-bold text-gray-500 uppercase tracking-widest">Stock</th>
                                <th class="px-6 py-4 text-left font-bold text-gray-500 uppercase tracking-widest">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($products as $product)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <img src="{{ filter_var($product->image_path, FILTER_VALIDATE_URL) ? $product->image_path : ($product->image_path ? asset('storage/' . $product->image_path) : 'https://via.placeholder.com/150') }}" alt="{{ $product->name }}" class="w-16 h-16 object-cover border border-gray-200">
                                </td>
                                <td class="px-6 py-4 font-bold uppercase">{{ $product->name }}</td>
                                <td class="px-6 py-4 font-medium">RM {{ number_format($product->price, 2) }}</td>
                                <td class="px-6 py-4 font-medium">{{ $product->stock }}</td>
                                <td class="px-6 py-4 flex gap-4 mt-4">
                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="text-indigo-600 hover:text-indigo-900 font-bold uppercase tracking-widest text-xs">Edit</a>
                                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 font-bold uppercase tracking-widest text-xs">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>
