<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\OrderCartModel;
use App\Models\ProductModel;

// class OrderCartController extends Controller
// {
//     public function index(){
//         $ordercarts = OrderCartModel::with(['user','product'])->get();
//         return view('admin.order.index',compact('ordercarts'));
//     }
//     public function create(){
//         $users = User::where('role', '!=', 'admin')->get();
//         $products=ProductModel::get();
//         return view('admin.order.create',compact(['users','products']));
//     }
//     public function store(Request $request)
//     {
//             $user_id = $request->input('user_id');
//             $product_id=$request->input('product_id');
//             $qty = $request->input('quantity');

//             $product = ProductModel::find($request->product_id);
//             $order = OrderCartModel::create([
//                 'user_id' => $user_id,
//                 'product_id' => $product_id,
//                 'quantity' => $qty,
//                 'total_price' => $product->product_price * $qty,
//                 'status' => 'not_paid',
//             ]);

//             if($order){
//                 return redirect()->route('admin.order');
//             }
//     }

//     public function destroy($id){
//         $order = OrderCartModel::find($id);

//         if($order){
//             $order->delete();
//             return redirect()->route('admin.order')->with('success', 'Product In cart was delete!');
//         }else{
//             return response()->json(['msg'=>'The data can not delete']);
//         }
//     }

// }
