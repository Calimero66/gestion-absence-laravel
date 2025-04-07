<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" class="text-gray-900 dark:text-white" />
            <x-text-input id="name" class="block mt-1 w-full focus:text-indigo-500" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" class="text-gray-900 dark:text-white" />
            <x-text-input id="email" class="block mt-1 w-full focus:text-indigo-500" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-gray-900 dark:text-white" />
            <x-text-input id="password" class="block mt-1 w-full focus:text-indigo-500"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-gray-900 dark:text-white" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full focus:text-indigo-500"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Role -->
        <div class="mt-4">
            <x-input-label for="role" :value="__('Role')" class="text-gray-900 dark:text-white" />
            <select id="role" 
                name="role" 
                class="block mt-1 w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:text-indigo-500 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" 
                required
            >
                <option value="" disabled selected>Select your role</option>
                <option value="student" class="py-2">{{ __('Student') }}</option>
                <option value="teacher" class="py-2">{{ __('Teacher') }}</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-6">
            <a class="text-sm text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300" 
                href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium transition">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>