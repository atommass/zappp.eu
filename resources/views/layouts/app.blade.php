
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>zappp.eu</title>

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
            // Initialize theme on page load
            if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
                localStorage.setItem('color-theme', 'dark');
            } else {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('color-theme', 'light');
            }
        </script>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900 flex flex-col">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>

            <footer class="mt-auto border-t border-gray-200 dark:border-gray-700">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                    <a href="{{ route('cookie.policy') }}" class="text-sm text-gray-500 hover:underline dark:text-gray-400">Cookie Policy</a>
                </div>
            </footer>
        </div>

        @include('partials.cookie-banner')

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
    </body>
</html>
