<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-white min-h-[60vh]">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <div class="mb-8 flex justify-between items-center">
                <h3 class="text-2xl font-black uppercase tracking-tighter border-b-2 border-black inline-block pb-1">Add New Product</h3>
                <a href="{{ route('admin.products.index') }}" class="text-gray-500 hover:text-black font-bold uppercase tracking-widest text-sm transition">
                    &larr; Back to Products
                </a>
            </div>

            <div class="bg-gray-50 p-8 border border-gray-200">
                <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-widest mb-2">Product Name</label>
                        <input type="text" name="name" class="w-full border-gray-300 focus:border-black focus:ring-black rounded-none shadow-sm" required>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-widest mb-2">Description</label>
                        <textarea name="description" rows="4" class="w-full border-gray-300 focus:border-black focus:ring-black rounded-none shadow-sm" required></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-widest mb-2">Price (RM)</label>
                            <input type="number" step="0.01" name="price" class="w-full border-gray-300 focus:border-black focus:ring-black rounded-none shadow-sm" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-widest mb-2">Stock Quantity</label>
                            <input type="number" name="stock" class="w-full border-gray-300 focus:border-black focus:ring-black rounded-none shadow-sm" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-widest mb-2">Product Image</label>
                        <input type="file" name="image" accept="image/*" class="w-full border-gray-300 focus:border-black focus:ring-black rounded-none shadow-sm bg-white p-2 border">
                        <p class="text-[10px] text-gray-400 uppercase tracking-widest mt-1">Recommended size: 800x800px. Max: 5MB.</p>
                    </div>

                    <button type="submit" class="w-full bg-black text-white px-6 py-4 text-sm font-bold uppercase tracking-widest hover:bg-gray-800 transition">
                        Save Product
                    </button>
                </form>
            </div>
            
        </div>
    </div>
</x-app-layout>
