<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Link') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                        <form action="{{ route('links.update', $link) }}" method="POST" x-data="{
                            never: {{ old('never') ? 'true' : (is_null($link->expires_at) ? 'true' : 'false') }},
                            expires: '{{ old('expires_at', $link->expires_at ? $link->expires_at->format("Y-m-d\\TH:i") : '') }}',
                            passwordEnabled: {{ old('password_enabled') ? 'true' : ($link->password_hash ? 'true' : 'false') }},
                            init(){
                                // ensure string values
                                this.expires = this.expires || '';
                                if (this.never) {
                                    this.expires = '';
                                } else if (!this.expires) {
                                    const d = new Date(); d.setDate(d.getDate() + 90);
                                    this.expires = d.toISOString().slice(0,16);
                                }
                                // if flatpickr is initialized, update its date
                                const el = document.getElementById('expires_at');
                                if (el && el._flatpickr) { el._flatpickr.setDate(this.expires || null, true); }
                            },
                            toggleNever(){
                                if (this.never) {
                                    this.expires = '';
                                    const el = document.getElementById('expires_at');
                                    if (el && el._flatpickr) { el._flatpickr.clear(); }
                                } else {
                                    const d = new Date(); d.setDate(d.getDate() + 90);
                                    this.expires = d.toISOString().slice(0,16);
                                    const el = document.getElementById('expires_at');
                                    if (el && el._flatpickr) { el._flatpickr.setDate(this.expires, true); }
                                }
                            }
                        }">
                        @csrf
                        @method('PATCH')

                        <div class="mb-4">
                            <label for="target" class="block text-gray-700 dark:text-gray-300">URL</label>
                            <input type="url" id="target" name="target" required class="w-full p-2 border border-gray-300 dark:border-gray-600 dark:text-gray-800 rounded-lg" value="{{ old('target', $link->target) }}">
                            @error('target')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="inline-flex items-center">
                                <input type="checkbox" x-model="passwordEnabled" name="password_enabled" value="1" class="form-checkbox mr-2">
                                <span class="text-sm text-gray-700 dark:text-gray-300">Password protect</span>
                            </label>

                            <div class="mt-2" x-cloak x-show="passwordEnabled">
                                <label for="password" class="block text-gray-700 dark:text-gray-300">New password</label>
                                <input type="password" id="password" name="password" class="w-full p-2 border border-gray-300 dark:border-gray-600 dark:text-gray-800 rounded-lg" placeholder="Leave blank to keep current">
                                @error('password')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="expires_at" class="block text-gray-700 dark:text-gray-300">Expiration</label>
                            <input type="text" id="expires_at" x-model="expires" name="expires_at" placeholder="Select date and time" class="w-full p-2 border border-gray-300 dark:border-gray-600 dark:text-gray-800 rounded-lg">
                            <p class="text-xs text-gray-500 mt-1">Leave blank to keep current expiry. Check "Never expire" to remove expiry.</p>
                            @error('expires_at')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <label class="inline-flex items-center mt-2">
                                <input type="checkbox" x-model="never" @change="toggleNever()" name="never" value="1" class="form-checkbox mr-2">
                                <span class="text-sm text-gray-700 dark:text-gray-300">Never expire</span>
                            </label>
                        </div>

                        <div class="flex items-center gap-2">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Save</button>
                            <a href="{{ route('dashboard') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
