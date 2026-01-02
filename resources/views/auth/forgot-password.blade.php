<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    @php
        $prUntil = session('password_reset_backoff_until');
        $prRemaining = $prUntil ? max(0, (int) $prUntil - now()->timestamp) : 0;
    @endphp

    <form method="POST" action="{{ route('password.email') }}"
        x-data="{ remaining: {{ $prRemaining }} }"
        x-init="if (remaining > 0) { const t = setInterval(() => { if (remaining > 0) { remaining--; } else { clearInterval(t); } }, 1000); }">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4 space-x-3">
            <div class="flex items-center space-x-2">
                <span x-show="remaining > 0" x-cloak class="text-sm text-gray-500 mr-5">
                    <span x-text="remaining + 's'"></span>
                </span>
                <x-primary-button
                    class="disabled:opacity-50 disabled:cursor-not-allowed"
                    :disabled="$prRemaining > 0"
                    x-bind:disabled="remaining > 0">
                    {{ __('Email Password Reset Link') }}
                </x-primary-button>                
            </div>
        </div>
    </form>
</x-guest-layout>
