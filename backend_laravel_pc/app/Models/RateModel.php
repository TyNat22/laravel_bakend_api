<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RateModel extends Model
{
    protected $table = 'rates';
    protected $fillable = ['user_id', 'product_id', 'rating', 'review'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(ProductModel::class);
    }
}
