<?php

namespace App\Models;

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
        return $this->belongsTo(User::class);
    }
    public function items()
    {
        return $this->hasMany(OrderItemModel::class,'id');
    }
}
