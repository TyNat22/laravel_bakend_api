<?php

namespace App\Http\Controllers\Api;

use App\Models\RateModel;
use App\Models\ProductModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RateController extends Controller
{
    public function index()
    {
        $rate = RateModel::with('product')
            ->where('user_id', auth()->user()->id)
            ->get();
        if ($rate) {
            return response()->json([
                'ratings' => $rate,
            ]);
        }
        return response()->json([
            'ratings' => 'not found',

        ]);
    }
    public function store(Request $request, ProductModel $product)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string',
        ]);

        $customer = Auth::user();

        // Optional: Prevent multiple ratings by same customer
        $existing = RateModel::where('user_id', $customer->id)
                        ->where('product_id', $product->id)
                        ->first();

        if ($existing) {
            return response()->json(['message' => 'You have already rated this product.'], 409);
        }

        $rate = RateModel::create([
            'user_id' => $customer->id,
            'product_id' => $product->id,
            'rating' => $request->rating,
            'review' => $request->review,
        ]);

        return response()->json(['message' => 'Rated successfully!', 'data' => $rate], 201);
    }
    public function destroy(RateModel $rate)
    {
        if (Auth::id() !== $rate->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $rate->delete();

        return response()->json(['message' => 'Rating deleted.'], 200);
    }
    public function update(Request $request, RateModel $rate)
    {
        if (Auth::id() !== $rate->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string',
        ]);

        $rate->update($request->only('rating', 'review'));

        return response()->json(['message' => 'Rating updated.', 'data' => $rate], 200);
    }
}
