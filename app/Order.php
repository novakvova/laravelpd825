<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id'
    ];
    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class);//('App\Product');// Product::class);
    }
}
