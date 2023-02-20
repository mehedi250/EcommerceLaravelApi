<?php

namespace App\Services;

use App\Interfaces\Repository\CategoryRepository;
use App\Interfaces\Repository\ProductRepository;
use App\Interfaces\Service\ProductContact;
use App\Models\Category;
use App\Models\Product;

class ProductService implements ProductContact{

    private $productRepository;
    private $categoryRepository;

    public function __construct(ProductRepository $productRepository, CategoryRepository $categoryRepository)
    {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
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
                    'message' => 'Product Deeleted Successfully',
                    'status' => 'success'
                ];
            }else{
                return [
                    'message' => 'Something went wrong!',
                    'status' => false
                ]; 
            }
        }catch (\Throwable $th) {
            return [
                'message' => 'Something went wrong!',
                'status' => false
            ];
        }
    }

    public function getProductsByCategorySlug($request, $slug)
    {
        try {
            $where = [['slug', $slug], ['status', Category::STATUS_ACTIVE]];
            $response = $this->categoryRepository->getCategoryByWhere($where, ['id', 'name']);
            if(!empty($response)){
                $logic = [['status', Product::STATUS_ACTIVE], ['category_id', $response->id]];
                $data = $this->productRepository->getProductsByWhere($logic, ['*']);

                if($data){
                    return [
                        'success' => true,
                        'data' => $data,
                        'status' => 'success'
                    ];
                }
            }
            return [
                'data' => [],
                'success' => true,
                'status' => 'error'
            ];
            
        }catch (\Throwable $th) {
            return [
                'data' => [],
                'success' => true,
                'status' => 'error'
            ];
        }

    }



}