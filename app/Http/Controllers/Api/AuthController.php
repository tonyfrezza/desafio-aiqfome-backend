<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Http\Requests\Api\Auth\AuthRequest;
use App\Http\Resources\LoginResource;
use Illuminate\Support\Facades\RateLimiter;

class AuthController extends Controller
{
    private const FAILED_LOGIN_ATTEMPTS = 5;
    private const LOCKOUT_TIME = 60;

    public function login(AuthRequest $request)
    {
        $key = 'login-attempts:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, self::FAILED_LOGIN_ATTEMPTS)) {
            return response()->json(['message' => 'Muitas tentativas de login. Tente novamente mais tarde.'], 429);
        }

        if (!auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
            RateLimiter::hit($key, self::LOCKOUT_TIME);
            return response()->json(['message' => 'Credenciais inválidas'], 401);
        }

        RateLimiter::clear($key);
        auth()->user()->tokens()->delete();
        $token = auth()->user()->createToken('user_token')->plainTextToken;

        return (new LoginResource(auth()->user(), $token));
    }
}
