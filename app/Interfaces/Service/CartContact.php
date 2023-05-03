<?php

namespace App\Interfaces\Service;
use Illuminate\Http\Request;

interface CartContact
{
    public function getAll();

    public function findDataById($id);

    public function insertToCart($data);

    public function updateCategory($data, $id);

    public function deleteCategory($id);

    public function getCategoryForDropdown();

    public function getCartByWhere($where, $column=['*']);

}