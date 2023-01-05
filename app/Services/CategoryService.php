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

    public function saveCategory($request)
    {
        $validator = Validator::make($request->all(), [
            'slug' => 'bail|required|max:191',
            'name' => 'bail|required|max:191',
        ]);

        if ($validator->fails()) {
            return [
                'success' => false,
                'errors' => $validator->messages(),
                'status' => 'validation-error'
            ];
        }

        $data = [
            'slug' => $request->slug,
            'name' => $request->name,
            'description' => $request->description,
            'meta_title' => $request->meta_title,
            'meta_keywords' => $request->meta_keywords,
            'meta_description' => $request->meta_description,
            'status' => $request->status == true ? '1':'0'
        ];

        try {
            $response = $this->categoryRepository->insert($data);

            if($response){
                return [
                    'success' => true,
                    'message' => 'Category Insert Successfuly',
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

    public function updateCategory($request, $id)
    {
        $validator = Validator::make($request->all(), [
            'slug' => 'bail|required|max:191',
            'name' => 'bail|required|max:191',

        ]);

        if ($validator->fails()) {
            return [
                'success' => false,
                'errors' => $validator->messages(),
                'status' => 'validation-error'
            ];
        }

        $data = [
            'slug' => $request->slug,
            'name' => $request->name,
            'description' => $request->description,
            'meta_title' => $request->meta_title,
            'meta_keywords' => $request->meta_keywords,
            'meta_description' => $request->meta_description,
            'status' => $request->status == true ? '1':'0'
        ];

        try {
            $response = $this->categoryRepository->update($id, $data);

            if($response){
                return [
                    'success' => true,
                    'message' => 'Category Update Successfuly',
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