<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CartProduct extends Model
{
    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity'
    ];
    public function product()
    {
        return $this->belongsTo(Product::class);//('App\Category', 'foreign_key');
    }
    public function cart()
    {
        return $this->belongsTo(Cart::class);//('App\Category', 'foreign_key');
    }
}
