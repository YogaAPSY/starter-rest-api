<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use App\Services\AuthService;

class AuthController extends Controller
{
    protected $service;
    public function __construct(AuthService $service)
    {
        $this->service = $service;
    }

    public function login(LoginRequest $request)
    {
        $request->validated();
        return $this->service->loginService($request);
    }

    public function logout(Request $request)
    {
        return $this->service->logoutService($request);
    }

    public function refreshToken()
    {
    }
}
