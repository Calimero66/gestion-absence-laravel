<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-2xl font-bold text-gray-900 dark:text-white" />
            <x-text-input id="email" 
                class="block mt-1 w-full border-indigo-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm dark:border-indigo-600 dark:bg-gray-700" 
                type="email" 
                name="email" 
                :value="old('email')" 
                required 
                autofocus 
                autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-2xl font-bold text-gray-900 dark:text-white" />

            <x-text-input id="password" 
                class="block mt-1 w-full  focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm dark:border-indigo-600 dark:bg-gray-700"
                type="password"
                name="password"
                required 
                autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" 
                    type="checkbox" 
                    class="rounded border-indigo-300 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:border-indigo-600" 
                    name="remember">
                <span class="ms-2 text-sm text-gray-900 dark:text-white">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="text-sm text-gray-900 hover:text-gray-700 dark:text-white dark:hover:text-gray-300" 
                    href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>