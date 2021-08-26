<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\User;

class UserRepository
{
    protected $model;
    public function __construct()
    {
        $this->model = new User;
    }

    public static function listUserRepository()
    {
        return User::all();
    }

    public function storeUserRepository($request)
    {
        $this->model->username = $request['username'];
        $this->model->name = $request['name'];
        $this->model->password = bcrypt($request['password']);

        $this->model->save();
        return $this->model;
    }

    public function updateUserRepository($request, $id)
    {
        if (isset($request['password'])) $request['password'] = bcrypt($request['password']);
        return $this->model::where('id', $id)->update($request);
    }

    public function showUserRepository($id)
    {
        return $this->model::where('id', $id)->first();
    }

    public function destroyUserRepository($id)
    {
        return $this->model::where('id', $id)->delete();
    }
}
