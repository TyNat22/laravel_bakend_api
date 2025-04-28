<?php

namespace App\Http\Controllers;

use App\Models\ProductModel;
use App\Models\User;
use App\Models\RateModel;
use Illuminate\Http\Request;

class RateController extends Controller
{
    public function index(){

        $ratings = RateModel::with(['user', 'product'])->get();
        return view('admin.rate.index',compact('ratings'));
    }
    public function showUser($userId)
    {
        $user = User::findOrFail($userId);
        $ratings = RateModel::where('user_id', $userId)->with('product')->get();

        return view('admin.rate.showUser', compact('user', 'ratings'));
    }

    public function showProduct($productId)
    {
        $product = ProductModel::findOrFail($productId);
        $ratings = RateModel::where('product_id', $productId)->with('user')->get();

        return view('admin.rate.showProduct', compact('product', 'ratings'));
    }

}
