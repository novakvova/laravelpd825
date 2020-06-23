<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'category_id',
        'price',
        'count',
        'discount',
        'description'
    ];
    /**
     * Get the category that owns the product.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);//('App\Category', 'foreign_key');
    }
    public function cartProducts()
    {
        return $this->hasMany(CartProduct::class);//('App\Product');// Product::class);
    }
    /**
     * Get the productImages for the product.
     */
    public function productImages()
    {
        return $this->hasMany(ProductImage::class);//('App\Product');// Product::class);
    }
}
