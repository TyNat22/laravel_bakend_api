<?php

namespace App\Http\Controllers;

use App\Models\OrderItemModel;
use App\Models\OrderModel;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function saveOrder(Request $request){
        $order = new OrderModel();

        $order-> name = $request->name;
        $order-> email = $request->email;
        $order-> phone = $request->phone;
        $order-> address = $request->address;
        $order-> total_price = $request->total_price;
        $order-> payment_status = $request->payment_status;
        $order-> status = $request->status;
        $order-> user_id = $request->user()->id;
        $order->save();

        //save order_item
        foreach($request->cart as $item){
            $orderitem = new OrderItemModel();
            $orderitem->price = $item['qty'] * $item['price'];
            $orderitem->qty= $item['qty'];
            $orderitem->product_id = $item['product_id'];
            $orderitem->save();


        }

    }
    public function index(){
        $orders =  OrderModel::orderBy('created_at','DESC')
                    ->get();
        return response()->json([
            'data' => $orders,
            'status'=>200
        ],200);
        // $order = OrderModel::with('items.product')->find(1);
        // dd($order);
    }
    public function show($id){
        $orders = OrderModel::with('items')->find($id);

        return response()->json([
            'data' => $orders,
            'status'=>200
        ],200);
    }


}
