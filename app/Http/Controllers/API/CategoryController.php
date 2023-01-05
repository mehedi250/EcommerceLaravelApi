<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Interfaces\Repository\CategoryRepository;
use App\Interfaces\Service\CategoryContact;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    private $categoryRepository;
    private $categoryService;

    public function __construct(CategoryRepository $categoryRepository, CategoryContact $categoryService)
    {
        $this->categoryRepository = $categoryRepository;
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
        return response()->json($this->categoryService->saveCategory($request));
    }

    public function update(Request $request, $id)
    {
        return response()->json($this->categoryService->updateCategory($request, $id));
    }


    public function destroy($id)
    {
        try {
            $response = $this->categoryRepository->delete($id);
            if($response){
                return response()->json([
                    'success' => true,
                    'message' => 'Category Deleted Successfuly',
                    'status' => 'success'
                ]);
            }
        }catch (\Throwable $th) {
            return response()->json([
                'message' => 'Something went wrong!',
                'status' => false
            ]);
        }
    }

    public function getCategoryForDropdown()
    {
        $response = $this->categoryRepository->getByWhere(['id', 'name'], [['status', Category::STATUS_ACTIVE]]);

        return response()->json([
            'data' => $response,
            'success' => true,
            'status' => 'success'
        ]);
     

    }
}
