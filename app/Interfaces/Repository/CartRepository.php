<?php

namespace App\Interfaces\Repository;
use Illuminate\Http\Request;

interface CartRepository
{
    public function getAll();

    public function countCategory();

    public function getById($id);

    public function insertCart($data);

    public function update($id, $data);

    public function delete($id);

    public function getByWhere($column=['*'], $where);

    public function getCategoryByWhere($where, $column=['*']);
    
}