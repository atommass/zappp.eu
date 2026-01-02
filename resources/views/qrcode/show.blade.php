<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('QR Code') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-4">
                        <div class="text-sm text-gray-500 dark:text-gray-400">Short URL</div>
                        <a href="{{ $shortUrl }}" target="_blank" class="text-blue-500 hover:underline break-all">{{ $shortUrl }}</a>
                    </div>

                    <div class="bg-white inline-block p-4 rounded">
                        {!! $qr !!}
                    </div>

                    <div class="mt-6 flex items-center justify-between">
                        <a href="{{ route('qr.download', $link->slug) }}" class="bg-gray-800 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded">
                            Download QR code
                        </a>

                        <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:underline">
                            Back to dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
