<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Interfaces\Repository\CategoryRepository;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'slug' => 'bail|required|max:191',
            'name' => 'bail|required|max:191',

        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->messages(),
                'status' => 'validation-error'
            ]);
        }

        $data = [
            'slug' => $request->slug,
            'name' => $request->name,
            'description' => $request->description,
            'meta_title' => $request->meta_title,
            'meta_keywords' => $request->meta_keywords,
            'meta_description' => $request->meta_description,
            'status' => Category::STATUS_ACTIVE
        ];

        $response = $this->categoryRepository->insert($data);

        if($response){
            return response()->json([
                'success' => true,
                'message' => 'Category Insert Successfuly',
                'status' => 'success'
            ]);
        }

    }

    public function update(Request $request, Catagory $catagory)
    {
        //
    }


    public function destroy(Catagory $catagory)
    {
        //
    }
}
