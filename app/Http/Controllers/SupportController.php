<?php

namespace App\Http\Controllers;

use App\Mail\SupportContact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Carbon;

class SupportController extends Controller
{
    /**
     * Show the support contact form.
     */
    public function create(): View
    {
        return view('support');
    }

    /**
     * Handle contact form submission.
     */
    public function store(Request $request): RedirectResponse
    {
        // Honeypot: if filled, silently accept (spam bot)
        if ($request->filled('hp')) {
            return back()->with('status', 'support-sent');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        // Per-IP rate limiting: max 5 per hour
        $key = 'support:ip:'.$request->ip();
        $max = 5;
        $decay = 3600; // seconds

        if (RateLimiter::tooManyAttempts($key, $max)) {
            $seconds = RateLimiter::availableIn($key);
            $request->session()->put('support_backoff_until', Carbon::now()->addSeconds($seconds)->timestamp);

            return back()->withErrors(['name' => __('Please wait :seconds seconds before sending another support request.', ['seconds' => $seconds])]);
        }

        // Record this attempt
        RateLimiter::hit($key, $decay);

        // Send to site support address
        Mail::to('info@zippp.eu')->send(new SupportContact($validated));

        return back()->with('status', 'support-sent');
    }
}
