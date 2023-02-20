<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    
    protected $fillable = [
        'category_id',
        'meta_title',
        'meta_keyword',
        'meta_description',
        'slug',
        'name',
        'brand',
        'selling_price',
        'original_price',
        'image',
        'description',
        'quantity',
        'featured',
        'popular',
        'status'
    ];

    public function category(){
        return $this->belongsTo('App\Models\Category','category_id');
    }
}
