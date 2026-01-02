<x-guest-layout>
    <div class="space-y-6 mt-2 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h1 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Cookie Policy</h1>

        <div class="mt-2">
            <button type="button" onclick="(function(){var secure=(location.protocol==='https:')?'; Secure':'';document.cookie='zappp_cookie_consent=; Max-Age=0; Path=/; SameSite=Lax'+secure;try{var u=new URL(window.location.href);u.searchParams.set('show_cookie_banner','1');window.location.href=u.toString();}catch(e){window.location.reload();}})()" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-3 rounded">
                Change cookie settings
            </button>
        </div>

        <div class="space-y-4 text-sm text-gray-700 dark:text-gray-300">
            <p>
                This Cookie Policy explains what cookies are used on zippp.eu, why we use them, and how you can control them.
            </p>

            <h2 class="text-base font-semibold text-gray-900 dark:text-gray-100">Cookies we use</h2>
            <ul class="list-disc pl-5 space-y-2">
                <li>
                    <span class="font-medium">Essential cookies (required)</span>
                    <ul class="list-disc pl-5 mt-1 space-y-1">
                        <li><span class="font-medium">Session cookie</span> – keeps you logged in and maintains your session. Lifetime depends on the configured session settings (often up to a few hours) and/or until you close your browser.</li>
                        <li><span class="font-medium">CSRF/XSRF cookie</span> – protects forms against cross-site request forgery attacks. Lifetime generally follows the session lifetime.</li>
                    </ul>
                </li>
                <li>
                    <span class="font-medium">Preferences (optional)</span>
                    <ul class="list-disc pl-5 mt-1 space-y-1">
                        <li><span class="font-medium">Theme preference (localStorage)</span> – remembers your dark/light mode choice. This is stored in your browser local storage, not as a cookie.</li>
                    </ul>
                </li>
                <li>
                    <span class="font-medium">Analytics cookies (optional)</span>
                    <ul class="list-disc pl-5 mt-1 space-y-1">
                        <li><span class="font-medium">Google Analytics (GA4)</span> – used to measure traffic and usage patterns. Typical cookies include <span class="font-medium">_ga</span> (up to 2 years) and related GA cookies (lifetimes vary by cookie and may change over time).</li>
                    </ul>
                </li>
                <li>
                    <span class="font-medium">Consent cookie</span>
                    <ul class="list-disc pl-5 mt-1 space-y-1">
                        <li><span class="font-medium">Cookie consent</span> – stores your choice for whether analytics cookies are allowed. Lifetime is set for a limited period (e.g. months) and can be removed anytime.</li>
                    </ul>
                </li>
            </ul>

            <h2 class="text-base font-semibold text-gray-900 dark:text-gray-100">How to change consent or delete cookies</h2>
            <ul class="list-disc pl-5 space-y-2">
                <li>You can delete cookies at any time in your browser settings.</li>
                <li>If you delete the cookie-consent cookie, the consent banner will appear again and analytics will stay disabled until you opt in.</li>
                <li>You can also use private/incognito mode to avoid storing cookies beyond that session.</li>
            </ul>

            <p class="text-xs text-gray-500 dark:text-gray-400">
                This page may be updated if the site’s cookies or providers change.
            </p>
        </div>
    </div>
</x-guest-layout>

@push('scripts')
<script>
    (function (){
        window.zapppOpenCookieSettings = function () {
            var secure = (location.protocol === 'https:') ? '; Secure' : '';
            // Remove consent cookie so the banner reappears
            document.cookie = 'zappp_cookie_consent=; Max-Age=0; Path=/; SameSite=Lax' + secure;

            // Reload the current page with a query flag to force the banner to render
            try {
                var u = new URL(window.location.href);
                u.searchParams.set('show_cookie_banner', '1');
                window.location.href = u.toString();
            } catch (e) {
                // Fallback
                window.location.reload();
            }
        };
    })();
</script>
@endpush
