<?php

namespace App\Models;

use App\Http\Controllers\RateController;
use Illuminate\Database\Eloquent\Model;

class ProductModel extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'product_name',
        'CPU',
        'RAM',
        'storage',
        'VGA',
        'SCREEN',
        'product_rating',
        'product_price',
        'OS',
        'category_id',
        'label_id',
        'product_image'
    ];

    public function getUrlAttribute()
    {
        return asset('storage/' . $this->product_image);
    }
    public function category()
    {
        return $this->belongsTo(CategoryModel::class,'category_id');
    }
    public function label()
    {
        return $this->belongsTo(LabelModel::class,'label_id');
    }
    public function wishlist()
    {
        return $this->hasMany(ProductModel::class, 'product_id', 'id');
    }
    public function ratings()
    {
        return $this->hasMany(RateController::class);
    }
    public function ordercarts(){
        return $this->hasMany(ProductModel::class);
    }
    public function orderItems()
{
    return $this->hasMany(OrderItemModel::class);
}

}
