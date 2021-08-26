<?php

namespace App\Services;

use App\Exceptions\UserNotFoundException;
use App\Repositories\UserRepository;
use App\Transformers\UserTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserService
{
    protected $db;
    protected $repo;

    public function __construct(UserRepository $repo)
    {
        $this->repo = $repo;
    }

    public static function listUserService()
    {
        return UserRepository::listUserRepository();
    }

    public function storeUserService($request)
    {
        try {
            $createUser = $this->repo->storeUserRepository($request->all());

            return responder()->success($createUser, UserTransformer::class)->respond(201);
        } catch (\Exception $e) {
            return responder()->error(500, $e->getMessage())->respond(500);
        }
    }

    public function updateUserService($request, $id)
    {
        unset($request['_method']);
        $updateUser = $this->repo->updateUserRepository($request, $id);

        if (!$updateUser) {
            throw new ModelNotFoundException('User tidak ditemukan');
        }

        return $updateUser;
    }

    public function showUserService($id)
    {
        $showUser = $this->repo->showUserRepository($id);

        if (!$showUser) {
            throw new ModelNotFoundException('User tidak ditemukan');
        }

        return $showUser;
    }

    public function destroyUserService($id)
    {
        try {
            $deleteUser = $this->repo->destroyUserRepository($id);

            if (!$deleteUser) {
                return responder()->error(404, 'User tidak ditemukann.')->respond(404);
            }

            return responder()->success()->respond(202);
        } catch (\Exception $e) {
            return responder()->error(500, $e->getMessage())->respond(500);
        }
    }
}
