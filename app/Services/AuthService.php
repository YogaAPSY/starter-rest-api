<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Transformers\AuthTransformer;
use App\Repositories\AuthRepository;

class AuthService
{
    protected $db;
    protected $repo;

    public function __construct(AuthRepository $repo)
    {
        $this->db = app('db');
        $this->repo = $repo;
    }

    public function loginService($request)
    {
        try {
            $user = $this->repo->checkAccount($request->username);

            if (!$user) {

                logFile($request->ip(), 'WARNING', $request->username, ['activity' => 'Gagal Login', 'request' => 'User tidak ditemukan', 'endpoint' => 'auth/login']);
                return responder()->error(404, 'User tidak ditemukan')->respond(404);
            }

            $credentials = $request->only('username', 'password');

            if (Auth::guard('users')->attempt($credentials)) {

                $user->tokens()->get()->each->delete();
                $createdToken = $user->createToken('Users')->accessToken;

                logFile($request->ip(), 'INFO', $request->username, ['activity' => 'Berhasil Login', 'request' => 'Berhasil login', 'endpoint' => 'auth/login']);

                return responder()->success($user, AuthTransformer::class)->meta(['token' => $createdToken])->respond();
            } else {

                logFile($request->ip(), 'WARNING', $request->username, ['activity' => 'Gagal Login', 'request' => 'Username atau Password salah', 'endpoint' => 'auth/login']);

                return responder()->error(403, 'Email atau Password salah')->respond(403);
            }
        } catch (\Exception $e) {
            logFile($request->ip(), 'ERROR', $request->username, ['activity' => 'Gagal Login', 'request' => $e->getMessage(), 'endpoint' => 'auth/login']);

            return responder()->error(500, 'Gagal Login. Silahkan coba lagi.' . $e->getMessage())->respond(500);
        }
    }

    public function logoutService($request)
    {
        try {
            $request->user()->tokens()->get()->each->delete();
            return responder()->success()->respond();
        } catch (\Exception $e) {
            logFile($request->ip(), 'ERROR', $request->username, ['activity' => 'Gagal Logout', 'request' => $e->getMessage(), 'endpoint' => 'auth/logout']);
            return responder()->error(500, 'Gagal Logout. Silahkan coba lagi.')->respond(500);
        }
    }
}
