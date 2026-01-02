<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    private const IP_MAX_ATTEMPTS = 5;
    private const IP_DECAY_SECONDS = 3600;

    private const GLOBAL_MAX_ATTEMPTS = 3;
    private const GLOBAL_DECAY_SECONDS = 60;

    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $this->ensureIsNotRateLimited($request);

        RateLimiter::hit($this->ipThrottleKey($request), self::IP_DECAY_SECONDS);
        RateLimiter::hit($this->globalThrottleKey(), self::GLOBAL_DECAY_SECONDS);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        $request->session()->forget('register_backoff_until');

        return redirect(route('verification.notice', absolute: false));
    }

    private function ipThrottleKey(Request $request): string
    {
        return 'register:ip:'.$request->ip();
    }

    private function globalThrottleKey(): string
    {
        return 'register:global';
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    private function ensureIsNotRateLimited(Request $request): void
    {
        $limiters = [
            ['key' => $this->ipThrottleKey($request), 'max' => self::IP_MAX_ATTEMPTS],
            ['key' => $this->globalThrottleKey(), 'max' => self::GLOBAL_MAX_ATTEMPTS],
        ];

        foreach ($limiters as $limiter) {
            if (! RateLimiter::tooManyAttempts($limiter['key'], $limiter['max'])) {
                continue;
            }

            $seconds = RateLimiter::availableIn($limiter['key']);

            $request->session()->put('register_backoff_until', now()->addSeconds($seconds)->timestamp);

            throw ValidationException::withMessages([
                'email' => trans('auth.throttle', [
                    'seconds' => $seconds,
                    'minutes' => ceil($seconds / 60),
                ]),
            ]);
        }
    }
}
