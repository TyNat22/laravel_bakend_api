<?php

namespace App\Http\Controllers\Api;

use App\Models\OrderCart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\OrderModel;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',

            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'address' => 'required|string',
        ]);

        DB::beginTransaction();

        try {
            $total = collect($request->items)->sum(function ($item) {
                return $item['price'] * $item['qty'];
            });

            $order = OrderModel::create([
                'user_id' => Auth::id(), // Or pass manually
                'total_price' => $total,
                // 'status' => 'pending',
                // 'payment_status' => 'unpaid', // or use a real value if passed
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,

            ]);

            foreach ($request->items as $item) {
                OrderCart::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'qty' => $item['qty'],
                    'price' => $item['price'],
                ]);
            }

            DB::commit();

            return response()->json(['message' => 'Order placed successfully', 'order' => $order], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Order failed', 'details' => $e->getMessage()], 500);
        }
    }
    public function index()
    {
        $user = Auth::user();

        $orders = $user->orders()
            ->with(['carts.product']) // load related order_cart and product
            ->orderByDesc('created_at')
            ->get();

        return response()->json($orders);
    }
}
