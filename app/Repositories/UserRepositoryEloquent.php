<?php

namespace App\Repositories;

use App\Interfaces\Repository\UserRepository;
use App\Models\User;

class UserRepositoryEloquent implements UserRepository{

    public function countUserByWhere($where)
    {
        return User::where($where)->count();
    }

}