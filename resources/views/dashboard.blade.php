<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-3xl text-black uppercase tracking-tighter leading-tight">
            {{ __('My Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-white min-h-[60vh]">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-16">
            
            @if(session('success'))
            <div class="bg-black text-white px-6 py-4 uppercase tracking-widest text-sm font-bold shadow-sm">
                {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="bg-red-600 text-white px-6 py-4 uppercase tracking-widest text-sm font-bold shadow-sm">
                {{ session('error') }}
            </div>
            @endif

            <!-- Checkout Section if Cart is not empty -->
            @if(count($cart) > 0)
            <div>
                <h3 class="text-2xl font-black mb-6 uppercase tracking-tighter border-b-2 border-black inline-block pb-1">Pending Checkout</h3>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                    <div class="bg-gray-50 p-8 border border-gray-100">
                        <h4 class="text-sm font-bold uppercase tracking-widest text-gray-500 mb-6">Order Summary</h4>
                        @php $subtotal = 0; @endphp
                        @foreach($cart as $id => $item)
                            @php $subtotal += $item['price'] * $item['quantity']; @endphp
                            <div class="flex justify-between text-base py-3 border-b border-gray-200 last:border-0 font-medium">
                                <span class="uppercase text-black">{{ $item['name'] }} <span class="text-gray-400 ml-2">x{{ $item['quantity'] }}</span></span>
                                <span>RM {{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                            </div>
                        @endforeach
                        <div class="font-black border-t-2 border-black pt-4 mt-4 flex justify-between text-xl uppercase tracking-tight">
                            <span>Subtotal</span>
                            <span>RM {{ number_format($subtotal, 2) }}</span>
                        </div>
                    </div>

                    <div>
                        <form action="{{ route('checkout') }}" method="POST" class="space-y-6">
                            @csrf
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-widest">Shipping Region</label>
                                <select name="region" class="w-full rounded-none border-gray-300 focus:border-black focus:ring-black py-3 px-4 text-sm font-medium uppercase" required>
                                    <option value="">SELECT REGION</option>
                                    <option value="semenanjung">SEMENANJUNG MALAYSIA (+RM 10.00)</option>
                                    <option value="sabah_sarawak">SABAH & SARAWAK (+RM 15.00)</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-widest">Full Delivery Address</label>
                                <textarea name="address" rows="4" class="w-full rounded-none border-gray-300 focus:border-black focus:ring-black p-4 text-sm uppercase placeholder-gray-400" required placeholder="ENTER YOUR FULL ADDRESS HERE..."></textarea>
                            </div>

                            <button type="submit" class="w-full bg-black text-white px-6 py-5 text-sm font-bold uppercase tracking-widest hover:bg-gray-800 transition duration-300">
                                Confirm & Pay
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endif

            <!-- Order History -->
            <div>
                <h3 class="text-2xl font-black mb-8 uppercase tracking-tighter border-b-2 border-black inline-block pb-1">Order History</h3>
                
                @if($orders->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($orders as $order)
                        <div class="border border-gray-200 p-8 bg-white hover:border-black hover:shadow-lg transition duration-300 flex flex-col">
                            <div class="flex justify-between font-black border-b border-gray-100 pb-4 mb-6 text-lg">
                                <span class="uppercase tracking-tighter">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
                                <span>RM {{ number_format($order->total_price, 2) }}</span>
                            </div>
                            
                            <div class="flex-1 space-y-4 mb-6">
                                <div>
                                    <span class="block text-gray-400 uppercase tracking-widest text-xs font-bold mb-1">Status</span>
                                    <span class="uppercase font-black text-sm 
                                        @if($order->status == 'pending') text-yellow-600
                                        @elseif($order->status == 'paid') text-blue-600
                                        @elseif($order->status == 'cancelled') text-red-600
                                        @else text-green-600
                                        @endif
                                    ">{{ $order->status }}</span>
                                </div>
                                <div>
                                    <span class="block text-gray-400 uppercase tracking-widest text-xs font-bold mb-1">Tracking</span>
                                    <span class="font-semibold text-sm">{{ $order->tracking_number ?? 'NOT SHIPPED YET' }}</span>
                                </div>
                            </div>
                            
                            <div class="bg-gray-50 p-4 border border-gray-100">
                                <h4 class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-3 border-b border-gray-200 pb-2">Items Included</h4>
                                <ul class="space-y-2 text-xs font-medium uppercase">
                                    @foreach($order->items as $item)
                                        <li class="flex justify-between text-gray-800">
                                            <span class="truncate pr-4">{{ $item->product->name }}</span>
                                            <span class="text-gray-400 shrink-0">x{{ $item->quantity }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            @if($order->status === 'pending')
                            <div class="mt-6 flex gap-3">
                                <form action="{{ route('order.pay', $order) }}" method="POST" class="flex-1">
                                    @csrf
                                    <button type="submit" class="w-full bg-black text-white px-4 py-3 text-xs font-bold uppercase tracking-widest hover:bg-gray-800 transition duration-300">
                                        Pay Now
                                    </button>
                                </form>
                                <form action="{{ route('order.cancel', $order) }}" method="POST" class="flex-1" onsubmit="return confirm('Are you sure you want to cancel this order?')">
                                    @csrf
                                    <button type="submit" class="w-full bg-white text-red-600 border-2 border-red-600 px-4 py-3 text-xs font-bold uppercase tracking-widest hover:bg-red-600 hover:text-white transition duration-300">
                                        Cancel
                                    </button>
                                </form>
                            </div>
                            @elseif($order->status !== 'cancelled')
                            <div class="mt-6">
                                <a href="{{ route('order.invoice', $order) }}" target="_blank" class="block text-center w-full bg-white text-black border-2 border-black px-4 py-3 text-xs font-bold uppercase tracking-widest hover:bg-black hover:text-white transition duration-300">
                                    Download Invoice
                                </a>
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="border-2 border-dashed border-gray-200 p-16 text-center text-gray-400 uppercase tracking-widest text-sm font-bold bg-gray-50">
                        You haven't placed any orders yet.
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
