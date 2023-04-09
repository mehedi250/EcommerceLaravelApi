<?php

namespace App\Interfaces\Service;
use Illuminate\Http\Request;

interface ProductContact
{
    public function getAll();

    public function findDataById($id);
   
    public function saveProduct($data);

    public function updateProduct($data, $id);

    public function deleteProduct($id);

    public function getProductsByCategorySlug($slug);

    public function getProductDetails($slug);

}