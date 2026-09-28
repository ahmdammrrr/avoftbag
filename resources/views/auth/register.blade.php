<x-guest-layout>
    <div class="mb-10">
        <h2 class="text-3xl font-black text-gray-900 uppercase tracking-tighter">Create Account</h2>
        <p class="text-gray-500 mt-2 text-sm">Join AVOFTBAG. to experience premium mobility.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-xs font-bold text-gray-700 uppercase tracking-widest">Name</label>
            <input id="name" class="block mt-2 w-full border-gray-300 focus:border-black focus:ring-black rounded-none shadow-sm" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-bold text-gray-700 uppercase tracking-widest">Email</label>
            <input id="email" class="block mt-2 w-full border-gray-300 focus:border-black focus:ring-black rounded-none shadow-sm" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-xs font-bold text-gray-700 uppercase tracking-widest">Password</label>
            <input id="password" class="block mt-2 w-full border-gray-300 focus:border-black focus:ring-black rounded-none shadow-sm" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-xs font-bold text-gray-700 uppercase tracking-widest">Confirm Password</label>
            <input id="password_confirmation" class="block mt-2 w-full border-gray-300 focus:border-black focus:ring-black rounded-none shadow-sm" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full flex justify-center py-4 px-4 border border-transparent shadow-sm text-sm font-bold text-white bg-black hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black uppercase tracking-widest transition duration-300">
                Register
            </button>
        </div>
        
        <div class="text-center mt-8">
            <p class="text-sm text-gray-500">
                Already have an account? 
                <a href="{{ route('login') }}" class="font-bold text-black hover:underline uppercase tracking-widest ml-1 text-xs">Log In</a>
            </p>
        </div>
    </form>
</x-guest-layout>
