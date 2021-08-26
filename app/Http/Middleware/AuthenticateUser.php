<?php

namespace App\Http\Middleware;

use Closure;
// use Laravel\Passport\Token;
// use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Factory as Auth;
// use Illuminate\Contracts\Auth\Guard;

class AuthenticateUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    public function handle($request, Closure $next, $role=null)
    {
        if ($this->auth->guest()) {
            return response()->json(
                [
                'success' => false,
                'message' => 'Unauthorized'
                ], 401
            );
        }

        return $next($request);
    }
}
