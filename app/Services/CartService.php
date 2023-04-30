<?php

namespace App\Services;

use App\Interfaces\Repository\CartRepository;
use App\Interfaces\Service\CartContact;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartService implements CartContact{

    private $cartRepository;

    public function __construct(CartRepository $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    public function getAll()
    {
        $response = $this->cartRepository->getAll();

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
        $response = $this->cartRepository->getById($id);

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

    public function insertCart($data)
    {
        try {
            $response = $this->cartRepository->insertCart($data);

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
            $response = $this->cartRepository->update($id, $data);

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
            $response = $this->cartRepository->delete($id);

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
        $response = $this->cartRepository->getByWhere(['id', 'name'], [['status', Category::STATUS_ACTIVE]]);

        return [
            'data' => $response,
            'success' => true,
            'status' => 'success'
        ];
    }

    public function getCategoryByWhere($where, $column=['*'])
    {
        $response = $this->cartRepository->getByWhere($column, $where);

        return [
            'data' => $response,
            'success' => true,
            'status' => 'success'
        ];
    }


}