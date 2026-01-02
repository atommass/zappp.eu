<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>zappp.eu</title>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    {{-- Load app CSS so shared UI (e.g. cookie banner) matches the rest of the site --}}
    @vite(['resources/css/app.css'])

    <!-- Local font: place Croogla files in public/fonts/ (Croogla-Medium.woff2 / .woff) -->
    <style>
        @font-face{
            font-family: 'Croogla Medium';
            src: url('../fonts/fonnts.com-croogla_4f-medium.otf') format('opentype');
            font-weight: 600 800;
            font-style: normal;
            font-display: swap;
        }
    </style>

    <style>
        /* Responsive adjustments for welcome page */
        .hero-title { font-size: 2.5rem; }
        .hero-sub { font-size: 1rem; }
        .hero-cta a { display: inline-block; }

        /* Offset content to avoid overlap with fixed header */
        .content-offset { padding-top: 5rem; }

        /* Header wrappers spacing */
        .logo-wrapper { left: 1.25rem; top: 1.25rem; }
        .controls-wrapper { right: 1.25rem; top: 1.25rem; }

        /* Mobile hamburger */
        .mobile-controls { display: none; }
        .welcome-mobile-menu { display: none; }

        @media (max-width: 640px) {
            .hero-title { font-size: 1.75rem; margin-bottom: .25rem; }
            .hero-sub { font-size: 0.95rem; padding: 0 1rem; }
            .hero-cta { flex-direction: column; gap: .5rem; }
            .hero-cta a { width: 100%; text-align: center; }

            .content-offset { padding-top: 6rem; }

            /* Reduce fixed header spacing on small screens and avoid overlap */
            .logo-wrapper {
                left: 50%;
                top: .5rem;
                transform: translateX(-50%);
                padding: .25rem .5rem !important;
            }
            /* Must beat the later `.flex { display:flex }` rule in this file */
            .controls-wrapper { display: none !important; }

            .mobile-controls { display: flex; right: .5rem; top: .5rem; padding: .25rem !important; }

            /* Shrink the logo text on mobile (overrides component CSS) */
            .logo-wrapper .application-logo-text { font-size: 2.5rem; }

            /* Slightly tighter vertical rhythm on mobile */
            .mt-6 { margin-top: 1rem; }

            .welcome-mobile-menu {
                position: fixed;
                top: 3.5rem;
                right: .5rem;
                left: .5rem;
                z-index: 9999;
            }
        }
    </style>

    <!-- Styles -->
    <style>
        html {
            line-height: 1.15;
            -webkit-text-size-adjust: 100%
        }

        body {
            margin: 0
        }

        a {
            background-color: transparent
        }

        [hidden] {
            display: none
        }

        html {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica Neue, Arial, Noto Sans, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol, Noto Color Emoji;
            line-height: 1.5
        }

        *,
        :after,
        :before {
            box-sizing: border-box;
            border: 0 solid #e2e8f0
        }

        a {
            color: inherit;
            text-decoration: inherit
        }

        svg,
        video {
            display: block;
        }

        video {
            max-width: 100%;
            height: auto
        }

        .bg-white {
            --tw-bg-opacity: 1;
            background-color: rgb(255 255 255 / var(--tw-bg-opacity))
        }

        .bg-gray-100 {
            --tw-bg-opacity: 1;
            background-color: rgb(243 244 246 / var(--tw-bg-opacity))
        }

        .border-gray-200 {
            --tw-border-opacity: 1;
            border-color: rgb(229 231 235 / var(--tw-border-opacity))
        }

        .border-t {
            border-top-width: 1px
        }

        .flex {
            display: flex
        }

        .grid {
            display: grid
        }

        .hidden {
            display: none
        }

        .items-center {
            align-items: center
        }

        .justify-center {
            justify-content: center
        }

        .font-semibold {
            font-weight: 600
        }

        .h-5 {
            height: 1.25rem
        }

        .h-8 {
            height: 2rem
        }

        .h-16 {
            height: 4rem
        }

        .text-sm {
            font-size: .875rem
        }

        .text-lg {
            font-size: 1.125rem
        }

        .leading-7 {
            line-height: 1.75rem
        }

        .mx-auto {
            margin-left: auto;
            margin-right: auto
        }

        .ml-1 {
            margin-left: .25rem
        }

        .mt-2 {
            margin-top: .5rem
        }

        .mr-2 {
            margin-right: .5rem
        }

        .ml-2 {
            margin-left: .5rem
        }

        .mt-4 {
            margin-top: 1rem
        }

        .ml-4 {
            margin-left: 1rem
        }

        .mt-8 {
            margin-top: 2rem
        }

        .ml-12 {
            margin-left: 3rem
        }

        .-mt-px {
            margin-top: -1px
        }

        .max-w-6xl {
            max-width: 72rem
        }

        .min-h-screen {
            min-height: 100vh
        }

        .overflow-hidden {
            overflow: hidden
        }

        .p-6 {
            padding: 1.5rem
        }

        .py-4 {
            padding-top: 1rem;
            padding-bottom: 1rem
        }

        .px-6 {
            padding-left: 1.5rem;
            padding-right: 1.5rem
        }

        .pt-8 {
            padding-top: 2rem
        }

        .fixed {
            position: fixed
        }

        .relative {
            position: relative
        }

        .top-0 {
            top: 0
        }

        .right-0 {
            right: 0
        }

        .shadow {
            --tw-shadow: 0 1px 3px 0 rgb(0 0 0 / .1), 0 1px 2px -1px rgb(0 0 0 / .1);
            --tw-shadow-colored: 0 1px 3px 0 var(--tw-shadow-color), 0 1px 2px -1px var(--tw-shadow-color);
            box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)
        }

        .text-center {
            text-align: center
        }

        .text-gray-200 {
            --tw-text-opacity: 1;
            color: rgb(229 231 235 / var(--tw-text-opacity))
        }

        .text-gray-300 {
            --tw-text-opacity: 1;
            color: rgb(209 213 219 / var(--tw-text-opacity))
        }

        .text-gray-400 {
            --tw-text-opacity: 1;
            color: rgb(156 163 175 / var(--tw-text-opacity))
        }

        .text-gray-500 {
            --tw-text-opacity: 1;
            color: rgb(107 114 128 / var(--tw-text-opacity))
        }

        .text-gray-600 {
            --tw-text-opacity: 1;
            color: rgb(75 85 99 / var(--tw-text-opacity))
        }

        .text-gray-700 {
            --tw-text-opacity: 1;
            color: rgb(55 65 81 / var(--tw-text-opacity))
        }

        .text-gray-900 {
            --tw-text-opacity: 1;
            color: rgb(17 24 39 / var(--tw-text-opacity))
        }

        .underline {
            text-decoration: underline
        }

        .antialiased {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale
        }

        .w-5 {
            width: 1.25rem
        }

        .w-8 {
            width: 2rem
        }

        .w-auto {
            width: auto
        }

        .grid-cols-1 {
            grid-template-columns: repeat(1, minmax(0, 1fr))
        }

        @media (min-width:640px) {
            .sm\:rounded-lg {
                border-radius: .5rem
            }

            .sm\:block {
                display: block
            }

            .sm\:items-center {
                align-items: center
            }

            .sm\:justify-start {
                justify-content: flex-start
            }

            .sm\:justify-between {
                justify-content: space-between
            }

            .sm\:h-20 {
                height: 5rem
            }

            .sm\:ml-0 {
                margin-left: 0
            }

            .sm\:px-6 {
                padding-left: 1.5rem;
                padding-right: 1.5rem
            }

            .sm\:pt-0 {
                padding-top: 0
            }

            .sm\:text-left {
                text-align: left
            }

            .sm\:text-right {
                text-align: right
            }
        }

        @media (min-width:768px) {
            .md\:border-t-0 {
                border-top-width: 0
            }

            .md\:border-l {
                border-left-width: 1px
            }

            .md\:grid-cols-2 {
                grid-template-columns: repeat(2, minmax(0, 1fr))
            }
        }

        @media (min-width:1024px) {
            .lg\:px-8 {
                padding-left: 2rem;
                padding-right: 2rem
            }
        }

        @media (prefers-color-scheme:dark) {
            .dark\:bg-gray-800 {
                --tw-bg-opacity: 1;
                background-color: rgb(31 41 55 / var(--tw-bg-opacity))
            }

            .dark\:bg-gray-900 {
                --tw-bg-opacity: 1;
                background-color: rgb(17 24 39 / var(--tw-bg-opacity))
            }

            .dark\:border-gray-700 {
                --tw-border-opacity: 1;
                border-color: rgb(55 65 81 / var(--tw-border-opacity))
            }

            .dark\:text-white {
                --tw-text-opacity: 1;
                color: rgb(255 255 255 / var(--tw-text-opacity))
            }

            .dark\:text-gray-400 {
                --tw-text-opacity: 1;
                color: rgb(156 163 175 / var(--tw-text-opacity))
            }

            .dark\:text-gray-500 {
                --tw-text-opacity: 1;
                color: rgb(107 114 128 / var(--tw-text-opacity))
            }
        }
    </style>

    <script>
        (function(){
            try{
                const prefers = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
                const stored = localStorage.getItem('color-theme');
                if(stored === 'dark' || (!stored && prefers)) document.documentElement.classList.add('dark');
                else document.documentElement.classList.remove('dark');
            }catch(e){console.error(e)}
        })();

        function toggleWelcomeTheme(){
            const html = document.documentElement;
            if(html.classList.contains('dark')){
                html.classList.remove('dark');
                localStorage.setItem('color-theme','light');
            } else {
                html.classList.add('dark');
                localStorage.setItem('color-theme','dark');
            }
            updateWelcomeIcons();
        }

        function updateWelcomeIcons(){
            const sun = document.getElementById('welcome-sun');
            const moon = document.getElementById('welcome-moon');

            const sunMobile = document.getElementById('welcome-sun-mobile');
            const moonMobile = document.getElementById('welcome-moon-mobile');

            const isDark = document.documentElement.classList.contains('dark');

            if(sun && moon){
                sun.style.display = isDark ? 'none' : 'inline';
                moon.style.display = isDark ? 'inline' : 'none';
            }

            if(sunMobile && moonMobile){
                sunMobile.style.display = isDark ? 'none' : 'inline';
                moonMobile.style.display = isDark ? 'inline' : 'none';
            }
        }

        function toggleWelcomeMenu(){
            const menu = document.getElementById('welcome-mobile-menu');
            if(!menu) return;
            const isOpen = menu.getAttribute('data-open') === '1';
            menu.style.display = isOpen ? 'none' : 'block';
            menu.setAttribute('data-open', isOpen ? '0' : '1');
        }

        function closeWelcomeMenu(){
            const menu = document.getElementById('welcome-mobile-menu');
            if(!menu) return;
            menu.style.display = 'none';
            menu.setAttribute('data-open', '0');
        }

        document.addEventListener('click', function (e) {
            const menu = document.getElementById('welcome-mobile-menu');
            const button = document.getElementById('welcome-menu-button');
            if(!menu || !button) return;
            if(menu.getAttribute('data-open') !== '1') return;
            if(menu.contains(e.target) || button.contains(e.target)) return;
            closeWelcomeMenu();
        });

        document.addEventListener('keydown', function (e) {
            if(e.key === 'Escape') closeWelcomeMenu();
        });

        document.addEventListener('DOMContentLoaded', updateWelcomeIcons);
    </script>

    <style>
        /* Welcome page theme + button styles (standalone page; no Tailwind build here) */
        .theme-toggle{background:transparent;border:none;padding:.25rem;margin-right:1rem;cursor:pointer;color:inherit}
        .btn-primary{background-color:rgb(79 70 229);color:#fff;padding:.5rem 1rem;border-radius:.375rem;border:2px solid rgb(79 70 229);display:inline-block;line-height:1.25rem;margin-right: 0.625rem;}
        .btn-primary:hover{background-color:rgb(67 56 202)}
        .btn-outline{background:transparent;color:rgb(79 70 229);padding:.45rem .9rem;border-radius:.375rem;border:2px solid rgb(79 70 229);display:inline-block;line-height:1.25rem}
        .btn-outline:hover{background-color:rgba(0,0,0,.04)}
        .muted{color:rgb(107 114 128)}

        /* Dark mode driven by the `.dark` class, like the main app */
        .dark .bg-gray-100{background-color:rgb(17 24 39)}
        .dark .bg-white{background-color:rgb(31 41 55)}
        .dark .border-gray-200{border-color:rgb(55 65 81)}
        .dark .text-gray-900{color:rgb(255 255 255)}
        .dark .text-gray-700{color:rgb(229 231 235)}
        .dark .text-gray-600{color:rgb(156 163 175)}
        .dark .text-gray-500{color:rgb(156 163 175)}
        .dark .text-gray-400{color:rgb(156 163 175)}
        .dark .muted{color:rgb(156 163 175)}

        .dark .btn-primary{background-color:rgb(37 99 235)}
        .dark .btn-primary:hover{background-color:rgb(29 78 216)}
        .dark .btn-outline{color:rgb(37 99 235);border-color:rgb(37 99 235)}
        .dark .btn-outline:hover{background-color:rgba(255,255,255,.06)}

        /* Page-level background and text colors to match main app behavior */
        body { background-color: #f3f4f6; color: #111827 }
        .dark body { background-color: #0f172a; color: #e6eef8 }

        /*
         * IMPORTANT:
         * This welcome page includes the default Laravel welcome CSS where `dark:` utilities
         * only activate via `@media (prefers-color-scheme: dark)`.
         * We override them here so `dark:` utilities follow the `html.dark` class toggle,
         * matching the main app behavior.
         */
        html.dark .dark\:bg-gray-900{background-color:rgb(17 24 39)}
        html:not(.dark) .dark\:bg-gray-900{background-color:rgb(243 244 246)}

        html.dark .dark\:bg-gray-800{background-color:rgb(31 41 55)}
        html:not(.dark) .dark\:bg-gray-800{background-color:rgb(255 255 255)}

        html.dark .dark\:border-gray-700{border-color:rgb(55 65 81)}
        html:not(.dark) .dark\:border-gray-700{border-color:rgb(229 231 235)}

        html.dark .dark\:text-white{color:rgb(255 255 255)}
        html:not(.dark) .dark\:text-white{color:rgb(17 24 39)}

        html.dark .dark\:text-gray-400{color:rgb(156 163 175)}
        html:not(.dark) .dark\:text-gray-400{color:rgb(75 85 99)}

        html.dark .dark\:text-gray-500{color:rgb(107 114 128)}
        html:not(.dark) .dark\:text-gray-500{color:rgb(55 65 81)}
    </style>

    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
</head>

<body class="antialiased">
    <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
        @if (Route::has('login'))
        <div class="fixed top-5 left-5 px-6 py-4 flex items-center logo-wrapper">
            <a href="/" class="inline-flex items-center">
                <x-application-logo class="w-8 h-8" />
            </a>
        </div>

        <div class="fixed top-5 right-5 px-6 py-4 items-center mobile-controls">
            <button id="welcome-menu-button" type="button" onclick="toggleWelcomeMenu()" aria-label="Open menu" class="p-2 rounded-lg border border-gray-200 bg-white text-gray-700 dark:bg-gray-800 dark:text-gray-200 dark:border-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 6h16" />
                    <path d="M4 12h16" />
                    <path d="M4 18h16" />
                </svg>
            </button>
        </div>

        <div id="welcome-mobile-menu" class="welcome-mobile-menu" style="display:none" data-open="0">
            <div class="rounded-lg border border-gray-200 bg-white shadow dark:border-gray-700 dark:bg-gray-800">
                <div class="p-3 space-y-2">
                    <button type="button" onclick="toggleWelcomeTheme(); closeWelcomeMenu();" class="w-full text-left px-3 py-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200">
                        <span style="display:inline-flex;align-items:center;gap:.5rem;">
                            <svg id="welcome-sun-mobile" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="5"></circle><path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/></svg>
                            <svg id="welcome-moon-mobile" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:none"><path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"></path></svg>
                            <span>Toggle theme</span>
                        </span>
                    </button>

                    @auth
                        <a href="{{ url('/dashboard') }}" onclick="closeWelcomeMenu()" class="block px-3 py-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" onclick="closeWelcomeMenu()" class="block px-3 py-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" onclick="closeWelcomeMenu()" class="block px-3 py-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200">Register</a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>

        <div class="fixed top-5 right-5 px-6 py-4 flex items-center space-x-3 controls-wrapper">
            <button class="theme-toggle" onclick="toggleWelcomeTheme()" aria-label="Toggle theme">
                <svg id="welcome-sun" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="5"></circle><path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/></svg>
                <svg id="welcome-moon" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:none"><path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"></path></svg>
            </button>
            @auth
                <a href="{{ url('/dashboard') }}" class="btn-primary">Dashboard</a>
                @else
                <a href="{{ route('login') }}" class="btn-primary">Log in</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn-outline">Register</a>
                @endif
            @endauth
        </div>
        @endif

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 content-offset">
            
            <!-- Hero -->
            <div class="mt-6 text-center">
                <h1 class="font-extrabold hero-title" style="margin-bottom:.5rem;">Shorten. Track. Share.</h1>
                <p class="muted hero-sub" style="max-width:720px;margin:0 auto 2rem">Create clean, branded links with zappp.eu and see exactly how your audience clicks.</p>
                <div class="hero-cta" style="display:flex;justify-content:center;gap:.5rem;margin-bottom:1rem">
                    <a href="{{ url('/register') }}" class="btn-primary">Create your first short link</a>
                    <a href="{{ url('/dashboard') }}" class="btn-outline">View dashboard</a>
                </div>
            </div>

            <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
                <div class="grid grid-cols-1 md:grid-cols-2">
                    <div class="p-6">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-gray-500">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                            <div class="ml-4 text-lg leading-7 font-semibold text-gray-900 dark:text-white">Instant short links</div>
                        </div>

                        <div class="ml-12">
                            <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                                Instant short links for social, email, SMS, ads, and more, without cluttered tracking parameters.
                            </div>
                        </div>
                    </div>

                    <div class="p-6 border-t border-gray-200 dark:border-gray-700 md:border-t-0 md:border-l">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-gray-500">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h4l3 8 4-16 3 8h4" />
                            </svg>
                            <div class="ml-4 text-lg leading-7 font-semibold text-gray-900 dark:text-white">Click analytics</div>
                        </div>

                        <div class="ml-12">
                            <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                                Built-in click analytics: countries, devices, referrers, and time-based performance for every link.
                            </div>
                        </div>
                    </div>

                    <div class="p-6 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-gray-500">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" />
                            </svg>
                            <div class="ml-4 text-lg leading-7 font-semibold text-gray-900 dark:text-white">Custom aliases</div>
                        </div>

                        <div class="ml-12">
                            <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                                Create your own name so every link looks professional and trustworthy.
                            </div>
                        </div>
                    </div>

                    <div class="p-6 border-t border-gray-200 dark:border-gray-700 md:border-l">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-gray-500">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 7h18M3 12h18M3 17h18" />
                            </svg>
                            <div class="ml-4 text-lg leading-7 font-semibold text-gray-900 dark:text-white">GDPR-friendly EU hosting</div>
                        </div>

                        <div class="ml-12">
                            <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                                GDPR-friendly EU hosting so your data and your customers’ data stay in Europe.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Feature highlights -->
            <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Feature highlights</h3>
                    <ul class="mt-4 ml-6 text-gray-600 dark:text-gray-400 text-sm list-disc">
                        <li>Basic shortening up to 20 links</li>
                        <li class="mt-2">Link controls such as expiry dates, password protection, and destination editing without changing the short link.</li>
                        <li class="mt-2">QR code generation for any short link to use in print, packaging, and offline campaigns.</li>
                    </ul>
                </div>
            </div>

            
            <div class="flex justify-center mt-4 sm:items-center sm:justify-between">
                <div class="text-center text-sm text-gray-500 sm:text-left">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="ml-4 -mt-px w-5 h-5 text-gray-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                        </svg>

                        <a href="/support" class="ml-1 underline">
                            Support
                        </a>

                        <span class="ml-2">•</span>
                        <a href="{{ route('cookie.policy') }}" class="ml-2 underline">
                            Cookie Policy
                        </a>
                    </div>
                </div>

                <div class="ml-4 text-center text-sm text-gray-500 sm:text-right sm:ml-0">
                    ZAPPP.EU &copy; {{ date('Y') }}
                </div>
            </div>
        </div>
    </div>

    @include('partials.cookie-banner')
</body>

</html>