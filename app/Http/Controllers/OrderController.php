<?php

namespace App\Http\Controllers;

use App\Models\OrderItemModel;
use App\Models\OrderModel;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function index()
    {
        $orders = OrderModel::with(['user', 'carts.product'])
        ->orderByDesc('created_at')
        ->get();

        return view('admin.order.index', compact('orders'));

        // return redirect()->route('admin.order',compact('orders'));
    }
    // public function show($id){
    //     $orders = OrderModel::with('items')->find($id);

    //     return response()->json([
    //         'data' => $orders,
    //         'status'=>200
    //     ],200);
    // }


}
