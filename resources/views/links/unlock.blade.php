<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Protected Link') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-lg mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <p class="text-sm text-gray-600 dark:text-gray-300">This link is password protected. Enter the password to continue.</p>

                    <form class="mt-4" action="{{ route('links.unlock.submit', $link->slug) }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="password" class="block text-gray-700 dark:text-gray-300">Password</label>
                            <input type="password" id="password" name="password" required class="w-full p-2 border border-gray-300 dark:border-gray-600 dark:text-gray-800 rounded-lg" autofocus>
                            @error('password')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Continue</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
