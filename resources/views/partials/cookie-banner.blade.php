@php($cookieConsent = request()->cookie('zappp_cookie_consent'))
@php($forceShow = request()->query('show_cookie_banner') === '1')

@if(!$cookieConsent || $forceShow)
    <div
        id="cookie-banner"
        class="fixed inset-x-0 bottom-0 z-50"
        style="position: fixed; left: 0; right: 0; bottom: 0; z-index: 9999;"
    >
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-4 rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <p class="text-sm text-gray-700 dark:text-gray-200">
                        We use essential cookies for login and security. Analytics cookies (Google Analytics) are optional.
                        <a href="{{ route('cookie.policy') }}" class="underline">Cookie Policy</a>
                    </p>
                    <div class="flex gap-2">
                        <button type="button" onclick="window.zapppSetCookieConsent('essential')" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded" style="padding: 0.5rem 1rem; border-radius: 0.375rem;">
                            Use essential only
                        </button>
                        <button type="button" onclick="window.zapppSetCookieConsent('analytics')" class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded" style="padding: 0.5rem 1rem; border-radius: 0.375rem;">
                            Accept analytics
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        (function () {
            function setCookie(name, value, maxAgeSeconds) {
                var secure = (location.protocol === 'https:') ? '; Secure' : '';
                document.cookie = name + '=' + encodeURIComponent(value)
                    + '; Max-Age=' + maxAgeSeconds
                    + '; Path=/'
                    + '; SameSite=Lax'
                    + secure;
            }

            window.zapppSetCookieConsent = function (level) {
                // Persist choice for ~6 months
                setCookie('zappp_cookie_consent', level, 60 * 60 * 24 * 180);

                var banner = document.getElementById('cookie-banner');
                if (banner) banner.remove();

                // Reload so server-rendered conditionals (e.g. GA snippet) can take effect
                location.reload();
            };
        })();
    </script>
@endif
