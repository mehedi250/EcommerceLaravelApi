<?php

namespace App\Repositories;

use App\Interfaces\Repository\CartRepository;
use App\Models\Cart;

class CartRepositoryEloquent implements CartRepository{

    public function insertCart($data)
    {
        return Cart::create($data);
    }

    public function update($id, $data)
    {
        return Cart::where('id', $id)->update($data);
    }

    public function getAll()
    {
        return Cart::all();
    }

    public function countCategory()
    {
        return Cart::where('status', 1)->count();
    }

    public function getById($id)
    {
        return Cart::where('id', $id)->first();
    }

    public function delete($id)
    {
        return Cart::where('id', $id)->delete();
    }

    public function getByWhere($column=['*'], $where)
    {
        return Cart::select($column)->where($where)->get();
    }

    public function getCartByWhere($where, $column=['*'])
    {
        return Cart::select($column)->where($where)->first();
    }

}