<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>zippp.eu</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @php($gaId = config('services.google.analytics_id'))
        @php($hasAnalyticsConsent = request()->cookie('zappp_cookie_consent') === 'analytics')
        @if($gaId && $hasAnalyticsConsent)
            <!-- Global site tag (gtag.js) - Google Analytics -->
            <script async src="https://www.googletagmanager.com/gtag/js?id={{ $gaId }}"></script>
            <script>
                window.dataLayer = window.dataLayer || [];
                function gtag(){dataLayer.push(arguments);} 
                gtag('js', new Date());
                gtag('config', '{{ $gaId }}', { anonymize_ip: true });
            </script>
        @endif
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <script>
            // Initialize theme on page load (match behavior in app layout)
            if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
                localStorage.setItem('color-theme', 'dark');
            } else {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('color-theme', 'light');
            }
        </script>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen relative flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
            <div class="w-[90%] sm:max-w-md px-6 mt-6 mb-5 relative">
                <a href="/" aria-label="Back to home" style="position:absolute;left:0;top:50%;transform:translateY(-50%);" class="inline-flex items-center p-2 rounded-md bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 shadow dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200 mr-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M15 18l-6-6 6-6" />
                    </svg>
                </a>

                <div class="text-center w-full">
                    <a href="/" class="inline-flex items-center justify-center mx-auto">
                        <x-application-logo class="w-20 fill-current text-gray-500" />
                    </a>
                </div>
            </div>

            <div class="w-[90%] sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg rounded-lg sm:mx-3">
                {{ $slot }}
            </div>

            <footer class="mt-6 max-w-7xl mx-auto sm:px-6 lg:px-8 py-4">
                <a href="{{ route('cookie.policy') }}" class="text-sm text-gray-500 hover:underline dark:text-gray-400">Cookie Policy</a>
            </footer>
        </div>

        @include('partials.cookie-banner')
    </body>

    <script>
        window.toggleTheme = function() {
            const html = document.documentElement;
            if (html.classList.contains('dark')) {
                html.classList.remove('dark');
                localStorage.setItem('color-theme', 'light');
            } else {
                html.classList.add('dark');
                localStorage.setItem('color-theme', 'dark');
            }

            if (typeof window.updateThemeIcons === 'function') {
                window.updateThemeIcons();
            }
        }
    </script>
    @stack('scripts')
</html>
