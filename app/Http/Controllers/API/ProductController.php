<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Interfaces\Repository\ProductRepository;
use App\Interfaces\Service\ProductContact;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    private $productService;

    public function __construct(ProductContact $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        return response()->json($this->productService->getAll());
    }

    public function find(Request $request)
    {
        return response()->json($this->productService->findDataById($request->id));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category' => 'bail|required',
            'slug' => 'bail|required|unique:products|max:191',
            'name' => 'bail|required|max:191',
            'meta_title' => 'bail|required|max:191',
            'brand' => 'bail|required|max:20',
            'selling_price' => 'bail|required|max:20',
            'original_price' => 'bail|required|max:20',
            'quantity' => 'bail|required|max:4',
            'image' => 'bail|required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->messages(),
                'status' => 'validation-error'
            ]);
        }

        $data = [
            'category_id' => $request->category,
            'slug' => $request->slug,
            'name' => $request->name,
            'meta_title' => $request->meta_title,
            'meta_keyword' => $request->meta_keyword,
            'meta_description' => $request->meta_description,
            'brand' => $request->brand,
            'description' => $request->description,
            'original_price' => $request->original_price,
            'quantity' => $request->quantity,
            'selling_price' => $request->selling_price,
            'featured' => $request->featured,
            'popular' => $request->popular,
            'status' => $request->status
        ];

        if($request->hasFile('image')){
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time(). '.' . $extension; 
            $file->move('uploads/images/product/', $filename); 

            $data['image'] = 'uploads/images/product/'.$filename;
        }

        return response()->json($this->productService->saveProduct($data));

    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'category' => 'bail|required',
            'slug' => 'bail|required|max:191|unique:products,slug,'.$id,
            'name' => 'bail|required|max:191',
            'meta_title' => 'bail|required|max:191',
            'brand' => 'bail|required|max:20',
            'selling_price' => 'bail|required|max:20',
            'original_price' => 'bail|required|max:20',
            'quantity' => 'bail|required|max:4',
            // 'image' => 'bail|required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->messages(),
                'status' => 'validation-error'
            ]);
        }

        $data = [
            'category_id' => $request->category,
            'slug' => $request->slug,
            'name' => $request->name,
            'meta_title' => $request->meta_title,
            'meta_keyword' => $request->meta_keyword,
            'meta_description' => $request->meta_description,
            'brand' => $request->brand,
            'description' => $request->description,
            'original_price' => $request->original_price,
            'quantity' => $request->quantity,
            'selling_price' => $request->selling_price,
            'featured' => $request->featured,
            'popular' => $request->popular,
            'status' => $request->status
        ];

        if($request->hasFile('image')){
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time(). '.' . $extension; 
            $file->move('uploads/images/product/', $filename); 

            $data['image'] = 'uploads/images/product/'.$filename;
        }
        
        return response()->json($this->productService->updateProduct($data, $id));

    }

    public function destroy($id)
    {
        try {
            $response = $this->productService->deleteProduct($id);
            if($response){
                return response()->json([
                    'success' => true,
                    'message' => 'Product Deleted Successfully',
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

    public function getProductsByCategorySlug(Request $request)
    {
        return response()->json($this->productService->getProductsByCategorySlug($request->slug));
    }

    public function getProductBySlug(Request $request)
    {
        return response()->json($this->productService->getProductBySlug($request->slug));
    }
}

