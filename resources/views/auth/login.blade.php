<x-guest-layout>
    <div class="mb-10">
        <h2 class="text-3xl font-black text-gray-900 uppercase tracking-tighter">Welcome Back</h2>
        <p class="text-gray-500 mt-2 text-sm">Please enter your details to sign in.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-bold text-gray-700 uppercase tracking-widest">Email</label>
            <input id="email" class="block mt-2 w-full border-gray-300 focus:border-black focus:ring-black rounded-none shadow-sm" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-xs font-bold text-gray-700 uppercase tracking-widest">Password</label>
            <input id="password" class="block mt-2 w-full border-gray-300 focus:border-black focus:ring-black rounded-none shadow-sm" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded-none border-gray-300 text-black shadow-sm focus:ring-black" name="remember">
                <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-xs font-bold text-gray-500 hover:text-black uppercase tracking-widest" href="{{ route('password.request') }}">
                    Forgot password?
                </a>
            @endif
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full flex justify-center py-4 px-4 border border-transparent shadow-sm text-sm font-bold text-white bg-black hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black uppercase tracking-widest transition duration-300">
                Log In
            </button>
        </div>
        
        <div class="text-center mt-8">
            <p class="text-sm text-gray-500">
                Don't have an account? 
                <a href="{{ route('register') }}" class="font-bold text-black hover:underline uppercase tracking-widest ml-1 text-xs">Register</a>
            </p>
        </div>
    </form>
</x-guest-layout>
