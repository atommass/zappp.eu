<x-guest-layout>
    @php
        $registerBackoffUntil = session('register_backoff_until');
        $registerBackoffRemaining = $registerBackoffUntil
            ? max(0, (int) $registerBackoffUntil - now()->timestamp)
            : 0;
    @endphp

    <form method="POST" action="{{ route('register') }}"
        x-data="{ remaining: {{ $registerBackoffRemaining }} }"
        x-init="if (remaining > 0) { const timer = setInterval(() => { if (remaining > 0) { remaining--; } else { clearInterval(timer); } }, 1000); }">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex flex-col items-center justify-end mt-4">
            <div x-show="remaining > 0" class="mb-3 text-sm text-red-600 dark:text-red-400" x-cloak>
                <span x-text="'Too many attempts. Try again in ' + remaining + 's.'"></span>
            </div>

            <x-primary-button
                class="ms-4 mb-5 mt-3 mr-3 disabled:opacity-50 disabled:cursor-not-allowed"
                :disabled="$registerBackoffRemaining > 0"
                x-bind:disabled="remaining > 0">
                {{ __('Register') }}
            </x-primary-button>
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>
        </div>
    </form>
</x-guest-layout>
