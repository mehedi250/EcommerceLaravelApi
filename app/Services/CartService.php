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

    public function insertToCart($data)
    {
        try {
            $where = [
                ['user_id', $data['user_id']],
                ['product_id', $data['product_id']]
            ];
            $responseCart = $this->cartRepository->getCartByWhere($where, ['id']);

            if(empty($responseCart)){
                $response = $this->cartRepository->insertCart($data);

                if($response){
                    return [
                        'success' => true,
                        'message' => 'Added to Cart',
                        'status' => 'success'
                    ];
                }    
            }else{
                return [
                    'success' => true,
                    'message' => 'Already Added to Cart',
                    'status' => 'warning'
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

    public function getCartByWhere($where, $column=['*'])
    {
        $response = $this->cartRepository->getCartByWhere($where, $column);

        return [
            'data' => $response,
            'success' => true,
            'status' => 'success'
        ];
    }


}