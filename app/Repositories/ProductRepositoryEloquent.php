<?php

namespace App\Repositories;
use App\Interfaces\Repository\ProductRepository;
use App\Models\Product;

class ProductRepositoryEloquent implements ProductRepository{

    public function insert($data)
    {
        return Product::create($data);
    }

    public function countProduct()
    {
        return Product::count();
    }

    public function update($id, $data)
    {
        return Product::where('id', $id)->update($data);
    }

    public function getAll()
    {
        return Product::with('category')->get();
    }

    public function getById($id)
    {
        return Product::where('id', $id)->first();
    }

    public function delete($id)
    {
        return Product::where('id', $id)->delete();
    }

}