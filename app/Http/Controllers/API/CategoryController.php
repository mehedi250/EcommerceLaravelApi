<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Interfaces\Service\CategoryContact;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    private $categoryService;

    public function __construct(CategoryContact $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        return response()->json($this->categoryService->getAll());
    }

    public function find($id)
    {
        return response()->json($this->categoryService->findDataById($id));
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
            'status' => $request->status == true ? '1':'0'
        ];
        return response()->json($this->categoryService->saveCategory($data));
    }

    public function update(Request $request, $id)
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
            'status' => $request->status == true ? '1':'0'
        ];

        return response()->json($this->categoryService->updateCategory($data, $id));
    }

    public function destroy($id)
    {
        return response()->json($this->categoryService->deleteCategory($id));
    }

    public function getCategoryForDropdown()
    {
        return response()->json($this->categoryService->getCategoryForDropdown());
    }

    public function getActiveCategory()
    {
        return response()->json($this->categoryService->getCategoryByWhere([['status', Category::STATUS_ACTIVE]], ['id', 'name', 'slug', 'description']));
    }


}
