<x-guest-layout>
    <div class="max-w-3xl mx-auto px-6 py-8 text-gray-900 dark:text-white">
        <h1 class="text-xl font-semibold mb-4 text-center">Do you need help? We're here for you.</h1>

        @if (session('status') == 'support-sent')
            <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                {{ __('Thanks — your message was sent. We will reply to the email you provided.') }}
            </div>
        @endif

        @php
            $sbUntil = session('support_backoff_until');
            $sbRemaining = $sbUntil ? max(0, (int) $sbUntil - now()->timestamp) : 0;
        @endphp

        <form method="POST" action="{{ route('support.send') }}"
            x-data="{ remaining: {{ $sbRemaining }} }"
            x-init="if (remaining > 0) { const t = setInterval(() => { if (remaining > 0) { remaining--; } else { clearInterval(t); } }, 1000); }">
            @csrf

            <div class="mb-4">
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-input-label for="message" :value="__('Message')" />
                <textarea id="message" name="message" rows="6" class="block mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100" required>{{ old('message') }}</textarea>
                <x-input-error :messages="$errors->get('message')" class="mt-2" />
            </div>

            <!-- Honeypot field (hidden from users) -->
            <div style="position:absolute;left:-10000px;top:auto;overflow:hidden;" aria-hidden="true">
                <label for="hp">Leave this field empty</label>
                <input id="hp" name="hp" type="text" autocomplete="off" tabindex="-1" />
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <x-primary-button
                        :disabled="$sbRemaining > 0"
                        x-bind:disabled="remaining > 0"
                        class="disabled:opacity-50 disabled:cursor-not-allowed">
                        {{ __('Send') }}
                    </x-primary-button>

                    <span x-show="remaining > 0" x-cloak class="text-sm text-gray-400 dark:text-gray-300">
                        <span x-text="remaining + 's'"></span>
                    </span>
                </div>

                <a href="https://www.buymeacoffee.com/zippp" target="_blank" rel="noopener noreferrer" class="text-sm text-gray-600 dark:text-gray-400 hover:underline">
                    Buy me a coffee
                </a>
            </div>
        </form>
    </div>
</x-guest-layout>
