<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\User;

class AuthRepository
{
    public function checkAccount($username)
    {
        $user = User::where('username', $username)->first();

        return $user;
    }
}
