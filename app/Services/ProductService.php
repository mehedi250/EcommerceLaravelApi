<?php

namespace App\Services;

use App\Interfaces\Repository\ProductRepository;
use App\Interfaces\Service\ProductContact;


class ProductService implements ProductContact{

    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getAll()
    {
        $response = $this->productRepository->getAll();

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
        $response = $this->productRepository->getById($id);

        if($response){
            return [
                'data' => $response,
                'success' => true,
                'status' => 'success'
            ];
        }else{
            return [
                'data' => null,
                'success' => true,
                'status' => 'error'
            ];
        }

    }

    public function saveProduct($data)
    {
        try {
            $response = $this->productRepository->insert($data);

            if($response){
                return [
                    'success' => true,
                    'message' => 'Product Insert Successfully',
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

    public function updateProduct($data, $id)
    {
        try {
            $response = $this->productRepository->update($id, $data);

            if($response){
                return [
                    'success' => true,
                    'message' => 'Product Update Successfully',
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

    public function deleteProduct($id)
    {
        try {
            $response = $this->productRepository->deleteById($id);
            if($response){
                return [
                    'success' => true,
                    'message' => 'Product Deleted Successfully',
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



}