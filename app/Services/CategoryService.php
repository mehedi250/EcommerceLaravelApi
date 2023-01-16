<?php

namespace App\Services;

use App\Interfaces\Repository\CategoryRepository;
use App\Interfaces\Service\CategoryContact;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryService implements CategoryContact{

    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getAll()
    {
        $response = $this->categoryRepository->getAll();

        if($response){
            return [
                'data' => $response,
                'success' => true,
                'status' => 'success'
            ];
        }
    }

    public function findDataById($id)
    {
        $response = $this->categoryRepository->getById($id);

        if($response){
            return [
                'data' => $response,
                'success' => true,
                'status' => 'success'
            ];
        }else{
            return [
                'message' => 'Category Not Found!',
                'success' => false,
                'status' => 'error'
            ];
        }
    }

    public function saveCategory($data)
    {
        try {
            $response = $this->categoryRepository->insert($data);

            if($response){
                return [
                    'success' => true,
                    'message' => 'Category Insert Successfully',
                    'status' => 'success'
                ];
            }
        }catch (\Throwable $th) {
            return [
                'message' => 'Something went wrong!',
                'status' => false
            ];
        }

    }

    public function updateCategory($data, $id)
    {
        try {
            $response = $this->categoryRepository->update($id, $data);

            if($response){
                return [
                    'success' => true,
                    'message' => 'Category Update Successfully',
                    'status' => 'success'
                ];
            }
        }catch (\Throwable $th) {
            return [
                'message' => 'Something went wrong!',
                'status' => false
            ];
        }
    }

    public function deleteCategory($id)
    {
        try {
            $response = $this->categoryRepository->delete($id);

            if($response){
                return [
                    'success' => true,
                    'message' => 'Category Deleted Successfully',
                    'status' => 'success'
                ];
            }
        }catch (\Throwable $th) {
            return [
                'message' => 'Something went wrong!',
                'status' => false
            ];
        }
    }

    public function getCategoryForDropdown()
    {
        $response = $this->categoryRepository->getByWhere(['id', 'name'], [['status', Category::STATUS_ACTIVE]]);

        return [
            'data' => $response,
            'success' => true,
            'status' => 'success'
        ];
    }


}