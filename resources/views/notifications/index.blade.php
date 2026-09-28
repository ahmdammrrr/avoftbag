<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-3xl text-black uppercase tracking-tighter leading-tight">
            {{ __('Notifications') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-white min-h-[60vh]">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
            <div class="bg-black text-white px-6 py-4 uppercase tracking-widest text-sm font-bold shadow-sm">
                {{ session('success') }}
            </div>
            @endif

            <!-- Header with Mark All as Read -->
            <div class="flex justify-between items-center">
                <p class="text-sm text-gray-500 uppercase tracking-widest font-bold">
                    {{ $notifications->where('is_read', false)->count() }} Unread
                </p>
                @if($notifications->where('is_read', false)->count() > 0)
                <form action="{{ route('notifications.readAll') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-black text-white px-5 py-2 text-xs font-bold uppercase tracking-widest hover:bg-gray-800 transition duration-300">
                        Mark All as Read
                    </button>
                </form>
                @endif
            </div>

            <!-- Notification List -->
            @if($notifications->count() > 0)
                <div class="space-y-3">
                    @foreach($notifications as $notification)
                    <div class="border {{ $notification->is_read ? 'border-gray-100 bg-white' : 'border-black bg-gray-50' }} p-6 flex items-start gap-5 transition hover:shadow-md group">
                        
                        <!-- Icon -->
                        <div class="shrink-0 mt-1">
                            @if($notification->type === 'order_placed')
                                <div class="w-10 h-10 {{ $notification->is_read ? 'bg-gray-100' : 'bg-black' }} flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ $notification->is_read ? 'text-gray-400' : 'text-white' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            @elseif($notification->type === 'order_cancelled')
                                <div class="w-10 h-10 {{ $notification->is_read ? 'bg-gray-100' : 'bg-red-600' }} flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ $notification->is_read ? 'text-gray-400' : 'text-white' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            @else
                                <div class="w-10 h-10 {{ $notification->is_read ? 'bg-gray-100' : 'bg-blue-600' }} flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ $notification->is_read ? 'text-gray-400' : 'text-white' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <!-- Content -->
                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-start mb-1">
                                <h4 class="font-black text-sm uppercase tracking-tight {{ $notification->is_read ? 'text-gray-400' : 'text-black' }}">
                                    {{ $notification->title }}
                                </h4>
                                <span class="text-[10px] text-gray-400 uppercase tracking-widest shrink-0 ml-4">
                                    {{ $notification->created_at->diffForHumans() }}
                                </span>
                            </div>
                            <p class="text-sm {{ $notification->is_read ? 'text-gray-400' : 'text-gray-700' }}">
                                {{ $notification->message }}
                            </p>
                        </div>

                        <!-- Mark as Read -->
                        @if(!$notification->is_read)
                        <div class="shrink-0">
                            <form action="{{ route('notifications.read', $notification->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-gray-400 hover:text-black transition" title="Mark as read">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            @else
                <div class="border-2 border-dashed border-gray-200 p-16 text-center text-gray-400 uppercase tracking-widest text-sm font-bold bg-gray-50">
                    No notifications yet.
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
