<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Link;
use Illuminate\Support\Facades\Hash;

class RedirectController extends Controller
{
    public function __invoke(Request $request, Link $link)
    {
        if ($link->isExpired()) {
            abort(404);
        }

        if ($link->isPasswordProtected()) {
            return redirect()->route('links.unlock', $link->slug);
        }

        $this->trackRedirect($request, $link);
        return redirect()->away($link->target);
    }

    public function unlockForm(Link $link)
    {
        if ($link->isExpired()) {
            abort(404);
        }

        if (!$link->isPasswordProtected()) {
            return redirect()->route('links.redirect', $link->slug);
        }

        return view('links.unlock', [
            'link' => $link,
        ]);
    }

    public function unlock(Request $request, Link $link)
    {
        if ($link->isExpired()) {
            abort(404);
        }

        if (!$link->isPasswordProtected()) {
            return redirect()->route('links.redirect', $link->slug);
        }

        $request->validate([
            'password' => 'required|string',
        ]);

        if (!Hash::check($request->input('password'), $link->password_hash)) {
            return back()->withErrors([
                'password' => 'Incorrect password.',
            ])->withInput();
        }

        // Successful unlock: count the redirect and send user to the target immediately.
        $this->trackRedirect($request, $link);
        return redirect()->away($link->target);
    }

    private function trackRedirect(Request $request, Link $link): void
    {
        $referer = $request->headers->get('referer');

        $country = $request->header('CF-IPCountry');
        if (is_string($country)) {
            $country = strtoupper(trim($country));
            if ($country === '' || $country === 'XX') {
                $country = null;
            }
        } else {
            $country = null;
        }

        $userAgent = $request->userAgent();

        $link->redirects()->create([
            'ip' => $request->ip(),
            'user_agent' => $userAgent,
            'referer' => $referer,
            'referrer_host' => $this->referrerHost($referer),
            'country_code' => $country,
            'device_type' => $this->detectDeviceType($userAgent),
        ]);
    }

    private function referrerHost(?string $referer): ?string
    {
        if (!$referer) {
            return null;
        }

        $host = parse_url($referer, PHP_URL_HOST);
        if (!is_string($host) || $host === '') {
            return null;
        }

        return $host;
    }

    private function detectDeviceType(?string $userAgent): string
    {
        if (!$userAgent) {
            return 'Unknown';
        }

        $ua = strtolower($userAgent);

        if (str_contains($ua, 'bot') || str_contains($ua, 'spider') || str_contains($ua, 'crawl')) {
            return 'Bot';
        }

        if (str_contains($ua, 'ipad') || str_contains($ua, 'tablet')) {
            return 'Tablet';
        }

        if (str_contains($ua, 'mobile') || str_contains($ua, 'android') || str_contains($ua, 'iphone')) {
            return 'Mobile';
        }

        return 'Desktop';
    }
}
