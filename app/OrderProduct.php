<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity'
    ];
    public function product()
    {
        return $this->belongsTo(Product::class);//('App\Category', 'foreign_key');
    }
    public function order()
    {
        return $this->belongsTo(Order::class);//('App\Category', 'foreign_key');
    }
}
