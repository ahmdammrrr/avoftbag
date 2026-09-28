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

            @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative shadow-sm">
                {{ session('error') }}
            </div>
            @endif

            <div class="mb-8 flex justify-between items-center">
                <h3 class="text-2xl font-black uppercase tracking-tighter border-b-2 border-black inline-block pb-1">Manage Users</h3>
                <div class="flex gap-4">
                    <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-black font-bold uppercase tracking-widest text-sm flex items-center transition">
                        &larr; Back to Orders
                    </a>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm border border-gray-200">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left font-bold text-gray-500 uppercase tracking-widest">ID</th>
                                <th class="px-6 py-4 text-left font-bold text-gray-500 uppercase tracking-widest">Name</th>
                                <th class="px-6 py-4 text-left font-bold text-gray-500 uppercase tracking-widest">Email</th>
                                <th class="px-6 py-4 text-left font-bold text-gray-500 uppercase tracking-widest">Role</th>
                                <th class="px-6 py-4 text-left font-bold text-gray-500 uppercase tracking-widest">Joined Date</th>
                                <th class="px-6 py-4 text-left font-bold text-gray-500 uppercase tracking-widest">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($users as $user)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 font-medium text-gray-500">{{ $user->id }}</td>
                                <td class="px-6 py-4 font-bold uppercase">{{ $user->name }}</td>
                                <td class="px-6 py-4 font-medium">{{ $user->email }}</td>
                                <td class="px-6 py-4">
                                    @if($user->role === 'admin')
                                        <span class="bg-black text-white px-3 py-1 text-[10px] font-bold uppercase tracking-widest">Admin</span>
                                    @else
                                        <span class="bg-gray-200 text-gray-700 px-3 py-1 text-[10px] font-bold uppercase tracking-widest">Customer</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-500">{{ $user->created_at->format('d M Y') }}</td>
                                <td class="px-6 py-4">
                                    @if($user->role !== 'admin')
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 font-bold uppercase tracking-widest text-xs">Delete</button>
                                    </form>
                                    @else
                                        <span class="text-gray-400 font-bold uppercase tracking-widest text-xs">-</span>
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
