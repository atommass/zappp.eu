<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    private const IP_MAX_ATTEMPTS = 30;
    private const IP_DECAY_SECONDS = 60;

    private const ACCOUNT_MAX_ATTEMPTS = 10;
    private const ACCOUNT_DECAY_SECONDS = 600;

    private const FAILURES_DECAY_SECONDS = 900;
    private const BACKOFF_START_AFTER = 5;
    private const BACKOFF_BASE_SECONDS = 5;
    private const BACKOFF_MAX_SECONDS = 300;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        if (! Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
            RateLimiter::hit($this->ipThrottleKey(), self::IP_DECAY_SECONDS);
            RateLimiter::hit($this->accountThrottleKey(), self::ACCOUNT_DECAY_SECONDS);
            RateLimiter::hit($this->failuresKey(), self::FAILURES_DECAY_SECONDS);

            $failures = RateLimiter::attempts($this->failuresKey());

            if ($failures >= self::BACKOFF_START_AFTER) {
                $waitSeconds = $this->computeBackoffSeconds($failures);
                RateLimiter::hit($this->backoffKey(), $waitSeconds);

                $this->session()->put('login_backoff_until', Carbon::now()->addSeconds($waitSeconds)->timestamp);

                throw ValidationException::withMessages([
                    'email' => trans('auth.throttle', [
                        'seconds' => $waitSeconds,
                        'minutes' => ceil($waitSeconds / 60),
                    ]),
                ]);
            }

            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->ipThrottleKey());
        RateLimiter::clear($this->accountThrottleKey());
        RateLimiter::clear($this->failuresKey());
        RateLimiter::clear($this->backoffKey());

        $this->session()->forget('login_backoff_until');
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        $limiters = [
            ['key' => $this->backoffKey(), 'max' => 1],
            ['key' => $this->ipThrottleKey(), 'max' => self::IP_MAX_ATTEMPTS],
            ['key' => $this->accountThrottleKey(), 'max' => self::ACCOUNT_MAX_ATTEMPTS],
        ];

        foreach ($limiters as $limiter) {
            if (! RateLimiter::tooManyAttempts($limiter['key'], $limiter['max'])) {
                continue;
            }

            event(new Lockout($this));

            $seconds = RateLimiter::availableIn($limiter['key']);

            if ($limiter['key'] === $this->backoffKey()) {
                $this->session()->put('login_backoff_until', Carbon::now()->addSeconds($seconds)->timestamp);
            }

            throw ValidationException::withMessages([
                'email' => trans('auth.throttle', [
                    'seconds' => $seconds,
                    'minutes' => ceil($seconds / 60),
                ]),
            ]);
        }
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    private function normalizedEmail(): string
    {
        return Str::transliterate(Str::lower($this->string('email')));
    }

    private function ipThrottleKey(): string
    {
        return 'login:ip:'.$this->ip();
    }

    private function accountThrottleKey(): string
    {
        return 'login:account:'.$this->normalizedEmail();
    }

    private function failuresKey(): string
    {
        return 'login:failures:'.$this->normalizedEmail().'|'.$this->ip();
    }

    private function backoffKey(): string
    {
        return 'login:backoff:'.$this->normalizedEmail().'|'.$this->ip();
    }

    private function computeBackoffSeconds(int $failures): int
    {
        $step = max(0, $failures - self::BACKOFF_START_AFTER);
        $multiplier = 2 ** min($step, 10);
        $seconds = (int) (self::BACKOFF_BASE_SECONDS * $multiplier);

        return min($seconds, self::BACKOFF_MAX_SECONDS);
    }
}
