<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Interfaces\Repository\ProductRepository;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function index()
    {
        $response = $this->productRepository->getAll();

        if($response){
            return response()->json([
                'data' => $response,
                'success' => true,
                'status' => 'success'
            ]);
        }
    }

    public function find($id)
    {
        $response = $this->productRepository->getById($id);

        if($response){
            return response()->json([
                'data' => $response,
                'success' => true,
                'status' => 'success'
            ]);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'bail|required',
            'slug' => 'bail|required|max:191',
            'name' => 'bail|required|max:191',
            'meta_title' => 'bail|required|max:191',
            'brand' => 'bail|required|max:20',
            'selling_price' => 'bail|required|max:20',
            'original_price' => 'bail|required|max:20',
            'qty' => 'bail|required|max:4',
            'image' => 'bail|required|image|mimes:jpeg|png|jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->messages(),
                'status' => 'validation-error'
            ]);
        }

        $data = [
            'category_id' => $request->category_id,
            'slug' => $request->slug,
            'name' => $request->name,
            'meta_title' => $request->meta_title,
            'meta_keyword' => $request->meta_keyword,
            'meta_description' => $request->meta_description,
            'brand' => $request->brand,
            'description' => $request->description,
            'original_price' => $request->original_price,
            'qty' => $request->qty,
            'featured' => $request->featured == true ? '1':'0',
            'popular' => $request->popular == true ? '1':'0',
            'status' => $request->status == true ? '1':'0'
        ];

        if($request->hasFile('image')){
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time(). '.' . $extension; 
            $file->move('uploads/images/product/', $filename); 

            $data['image'] = 'uploads/images/product/'.$filename;
        }

        try {
            $response = $this->productRepository->insert($data);

            if($response){
                return response()->json([
                    'success' => true,
                    'message' => 'Product Insert Successfuly',
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

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'bail|required',
            'slug' => 'bail|required|max:191',
            'name' => 'bail|required|max:191',
            'meta_title' => 'bail|required|max:191',
            'brand' => 'bail|required|max:20',
            'selling_price' => 'bail|required|max:20',
            'original_price' => 'bail|required|max:20',
            'qty' => 'bail|required|max:4',
            'image' => 'bail|required|image|mimes:jpeg|png|jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->messages(),
                'status' => 'validation-error'
            ]);
        }

        $data = [
            'category_id' => $request->category_id,
            'slug' => $request->slug,
            'name' => $request->name,
            'meta_title' => $request->meta_title,
            'meta_keyword' => $request->meta_keyword,
            'meta_description' => $request->meta_description,
            'brand' => $request->brand,
            'description' => $request->description,
            'original_price' => $request->original_price,
            'qty' => $request->qty,
            'featured' => $request->featured == true ? '1':'0',
            'popular' => $request->popular == true ? '1':'0',
            'status' => $request->status == true ? '1':'0'
        ];
        
        if($request->hasFile('image')){
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time(). '.' . $extension; 
            $file->move('uploads/images/product/', $filename); 

            $data['image'] = 'uploads/images/product/'.$filename;
        }

        try {
            $response = $this->productRepository->update($id, $data);

            if($response){
                return response()->json([
                    'success' => true,
                    'message' => 'Product Update Successfuly',
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

    public function destroy($id)
    {
        try {
            $response = $this->productRepository->delete($id);
            if($response){
                return response()->json([
                    'success' => true,
                    'message' => 'Product Deleted Successfuly',
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
}
