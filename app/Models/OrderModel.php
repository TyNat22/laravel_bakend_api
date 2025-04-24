<?php

namespace App\Models;

use App\Models\OrderCart;
use Illuminate\Database\Eloquent\Model;

class OrderModel extends Model
{
    protected $table = 'orders';

    protected $fillable =[
        'user_id',
        'total_price',
        'payment_status',
        'status',
        'name',
        'email',
        'phone',
        'address',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function carts()
    {
        return $this->hasMany(OrderCart::class, 'order_id', 'id');
    }
}
