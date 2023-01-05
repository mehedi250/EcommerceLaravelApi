<?php

namespace App\Interfaces\Service;
use Illuminate\Http\Request;

interface CategoryContact
{
    public function getAll();

    public function findDataById($id);

    public function saveCategory($request);

    public function updateCategory($request, $id);

}