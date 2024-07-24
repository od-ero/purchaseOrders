<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'login_userid' => ['required', 'string',],
            'login_password' => ['required', 'string',],
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
          
           $data= ["id" => base64_decode($this->login_userid),
           "password" => $this->login_password];
        if (! Auth::attempt($data, $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());
            //return response()->json(['status' => 'error', 'message' => 'Login reuest Authentication failed'], 401);
            throw ValidationException::withMessages([
                'id' => trans('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }
    public function authenticateDev(): void
    {
        $this->ensureIsNotRateLimited();
          
           $data= ["username" => $this->login_userid,
           "password" => $this->login_password];
        if (! Auth::attempt($data, $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());
            //return response()->json(['status' => 'error', 'message' => 'Login reuest Authentication failed'], 401);
            throw ValidationException::withMessages([
                'id' => trans('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'id' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('id')).'|'.$this->ip());
    }
}
