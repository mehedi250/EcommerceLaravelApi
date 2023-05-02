<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Interfaces\Service\CartContact;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    private $cartService;

    public function __construct(CartContact $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        return response()->json($this->cartService->getAll());
    }

    public function find($id)
    {
        return response()->json($this->cartService->findDataById($id));
    }

    public function insertCart(Request $request)
    {
        $user = auth()->user()->id;
        $validator = Validator::make($request->all(), [
            'product_id' => 'bail|required',
            'product_quantity' => 'bail|required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->messages(),
                'status' => 'validation-error'
            ]);
        }

        $data = [
            'user_id' => auth('sanctum')->user()->id,
            'product_id' => $request->product_id,
            'product_quantity' => $request->product_quantity
        ];
        return response()->json($this->cartService->insertToCart($data));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => $request->user()->id,
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

        return response()->json($this->cartService->updateCategory($data, $id));
    }

    public function destroy($id)
    {
        return response()->json($this->cartService->deleteCategory($id));
    }



}
