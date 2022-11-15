<?php

namespace App\Interfaces\Repository;
use Illuminate\Http\Request;

interface CategoryRepository
{
    public function getAll();

    public function getById($id);

    public function insert($data);

    public function update($id, $data);

    public function delete($id);
}
