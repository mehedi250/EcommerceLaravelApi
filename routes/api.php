<?php

use App\Http\Controllers\API\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum', 'isAPIAdmin'])->group( function(){
    Route::get('checkAuthenticated', function(){
        return response()->json(['message' => 'You are in', 'status'=>200], 200);
    });

    Route::group(['prefix' => 'admin', 'namespace' => 'App\Http\Controllers\API'], function(){
        //Category route
        Route::post('category-list', 'CategoryController@index');
        Route::post('category-store', 'CategoryController@store');
        Route::post('category-update/{id}', 'CategoryController@update');
        Route::post('category-delete/{id}', 'CategoryController@destroy');
        Route::post('category/{id}', 'CategoryController@find');
        Route::post('category-dropdown-list', 'CategoryController@getCategoryForDropdown');

        Route::post('product-save', 'ProductController@store');
        Route::post('product-update/{id}', 'ProductController@update');
        Route::post('product-list', 'ProductController@index');
        Route::post('product-details', 'ProductController@find');

        Route::post('dashboard-data', 'PageController@dashboardData');

    });
   
});

Route::middleware(['auth:sanctum'])->group( function(){
    Route::post('logout', [AuthController::class, 'logout']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


//user api route
Route::group([ 'namespace' => 'App\Http\Controllers\API'], function(){
    Route::post('get-active-categories', 'CategoryController@getActiveCategory');
    Route::post('get-category-products', 'ProductController@getProductsByCategorySlug');

});
