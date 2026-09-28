<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-3xl text-black uppercase tracking-tighter leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-white min-h-[60vh]">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-12">
            
            <div class="p-8 sm:p-12 bg-white border border-gray-200 hover:border-black transition duration-300">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-8 sm:p-12 bg-white border border-gray-200 hover:border-black transition duration-300">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-8 sm:p-12 bg-gray-50 border border-gray-200 hover:border-red-600 transition duration-300">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>
