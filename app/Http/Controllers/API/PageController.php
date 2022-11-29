<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Interfaces\Repository\CategoryRepository;
use App\Interfaces\Repository\ProductRepository;
use App\Interfaces\Repository\UserRepository;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PageController extends Controller
{
    private $categoryRepository;
    private $productRepository;
    private $userRepository;

    public function __construct(CategoryRepository $categoryRepository,
                                ProductRepository $productRepository,
                                UserRepository $userRepository
    )
    {
        $this->categoryRepository = $categoryRepository;
        $this->productRepository = $productRepository;
        $this->userRepository = $userRepository;
    }

    public function dashboardData()
    {
        $cardData['countCategory'] = $this->categoryRepository->countCategory();
        $cardData['countProduct'] = $this->productRepository->countProduct();
        $cardData['countUser'] = $this->userRepository->countUserByWhere([['role_as', User::ROLE_USER]]);
   
        return response()->json([
            'cardData' => (object)$cardData,
            'success' => true,
            'status' => 'success'
        ]);
    }


}
