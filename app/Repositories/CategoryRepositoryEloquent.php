<?php

namespace App\Repositories;
use App\Interfaces\Repository\CategoryRepository;
use App\Models\Category;

class CategoryRepositoryEloquent implements CategoryRepository{

    public function insert($data)
    {
        return Category::create($data);
    }

    public function update($id, $data)
    {
        return Category::where('id', $id)->update($data);
    }

    public function getAll()
    {
        return Category::all();
    }

    public function countCategory()
    {
        return Category::where('status', Category::STATUS_ACTIVE)->count();
    }

    public function getById($id)
    {
        return Category::where('id', $id)->first();
    }

    public function delete($id)
    {
        return Category::where('id', $id)->delete();
    }

    public function getByWhere($column=['*'], $where)
    {
        return Category::select($column)->where($where)->get();
    }

    public function getCategoryByWhere($where, $column=['*'])
    {
        return Category::select($column)->where($where)->first();
    }

}