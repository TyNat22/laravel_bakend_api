<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItemModel extends Model
{
    protected $table = 'orders_items';

    protected $fillable = [
        'user_id',
        'product_id',
        'price',
        'qty'
    ];
     // Relationship with Order
     public function order()
     {
         return $this->belongsTo(OrderModel::class,'order_id');
     }

     // Relationship with Product
     public function product()
     {
         return $this->belongsTo(ProductModel::class);
     }
}
