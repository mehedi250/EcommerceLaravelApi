<?php

namespace App\Interfaces\Repository;
use Illuminate\Http\Request;

interface UserRepository
{
    public function countUserByWhere($where);
}
