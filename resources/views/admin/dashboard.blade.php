<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-white min-h-[60vh]">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            @if(session('success'))
            <div class="bg-black text-white px-6 py-4 uppercase tracking-widest text-sm font-bold shadow-sm">
                {{ session('success') }}
            </div>
            @endif

            <!-- Manage Orders -->
            <div class="mb-8 flex justify-between items-center">
                <h3 class="text-2xl font-black uppercase tracking-tighter border-b-2 border-black inline-block pb-1">Manage Orders</h3>
                <div class="flex gap-4">
                    <a href="{{ route('admin.users.index') }}" class="bg-white text-black border-2 border-black px-6 py-3 text-sm font-bold uppercase tracking-widest hover:bg-black hover:text-white transition duration-300">
                        Manage Users
                    </a>
                    <a href="{{ route('admin.products.index') }}" class="bg-black text-white px-6 py-3 text-sm font-bold uppercase tracking-widest hover:bg-gray-800 transition duration-300">
                        Manage Products
                    </a>
                </div>
            </div>
            
            <div class="bg-white overflow-hidden border border-gray-200">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left font-bold text-gray-500 uppercase tracking-widest text-xs">Order ID</th>
                                <th class="px-6 py-4 text-left font-bold text-gray-500 uppercase tracking-widest text-xs">Customer Details</th>
                                <th class="px-6 py-4 text-left font-bold text-gray-500 uppercase tracking-widest text-xs">Total</th>
                                <th class="px-6 py-4 text-left font-bold text-gray-500 uppercase tracking-widest text-xs">Status & Tracking</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($orders as $order)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-6 font-black align-top text-lg">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                                <td class="px-6 py-6 align-top max-w-sm">
                                    <div class="font-bold text-black uppercase mb-1">{{ $order->user->name }}</div>
                                    <div class="text-gray-500 text-xs uppercase tracking-wider mb-4">{{ $order->user->email }}</div>
                                    <div class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Items Ordered</div>
                                    <div class="bg-white border border-gray-200 p-4 mb-4">
                                        <ul class="space-y-2">
                                            @foreach($order->items as $item)
                                            <li class="flex justify-between text-xs font-medium uppercase text-gray-700">
                                                <span>{{ $item->product->name }}</span>
                                                <span class="text-gray-400 ml-4 shrink-0">x{{ $item->quantity }} — RM {{ number_format($item->price * $item->quantity, 2) }}</span>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Shipping Address</div>
                                    <div class="text-xs font-medium uppercase bg-white p-4 border border-gray-200 text-gray-700">{{ $order->shipping_address }}</div>
                                </td>
                                <td class="px-6 py-6 font-bold align-top text-center">
                                    RM {{ number_format($order->total_price, 2) }}
                                    @if($order->status !== 'pending' && $order->status !== 'cancelled')
                                    <a href="{{ route('order.invoice', $order) }}" target="_blank" class="mt-4 block text-center w-full bg-white text-black border-2 border-black px-3 py-2 text-[10px] font-bold uppercase tracking-widest hover:bg-black hover:text-white transition duration-300">
                                        Invoice
                                    </a>
                                    @endif
                                </td>
                                <td class="px-6 py-6 align-top">
                                    @if($order->status === 'cancelled')
                                        <div class="bg-red-50 border border-red-200 p-4 text-center">
                                            <span class="text-red-600 font-black text-sm uppercase tracking-widest">Cancelled</span>
                                        </div>
                                    @else
                                    <form action="{{ route('admin.order.update', $order->id) }}" method="POST" class="flex flex-col gap-3">
                                        @csrf
                                        <select name="status" class="text-sm border-gray-300 focus:border-black focus:ring-black rounded-none uppercase font-bold text-xs p-3">
                                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="paid" {{ $order->status == 'paid' ? 'selected' : '' }}>Paid</option>
                                            <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                        </select>
                                        <input type="text" name="tracking_number" value="{{ $order->tracking_number }}" placeholder="TRACKING NUMBER" class="text-sm border-gray-300 focus:border-black focus:ring-black rounded-none uppercase text-xs p-3 placeholder-gray-400">
                                        <button type="submit" class="bg-black text-white px-4 py-3 text-xs font-bold uppercase tracking-widest hover:bg-gray-800 transition">Update</button>
                                    </form>
                                    @endif
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
