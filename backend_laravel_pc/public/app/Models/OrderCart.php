<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderCart extends Model
{
    protected $table = 'orders_carts';
    protected $fillable = [
        'order_id',
        'product_id',
        'qty',
        'price',
    ];
    public function order()
    {
        return $this->belongsTo(OrderModel::class);
    }

    public function product()
    {
        return $this->belongsTo(ProductModel::class);
    }

}
