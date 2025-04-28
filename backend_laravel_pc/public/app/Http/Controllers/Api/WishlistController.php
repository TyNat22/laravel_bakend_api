<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\WishlistModel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlist = WishlistModel::with(['product', 'user'])
            ->where('user_id', Auth::id())
            ->get();
        if ($wishlist) {
            return response()->json([
                'wishlist' => $wishlist,
            ]);
        }
        return response()->json([
            'wishlist' => 'wishlist not found',

        ]);
    }

public function store(Request $request)
{
    $request->validate(['product_id' => 'required|exists:products,id']);

    $wishlist = WishlistModel::firstOrCreate([
        'user_id' => Auth::user()->id,
        'product_id' => $request->product_id,
    ]);

    return response()->json(['message' => 'Added to wishlist', 'data' => $wishlist]);
}

public function destroy($id)
{
    $wishlist = WishlistModel::where('id', $id)->where('user_id', Auth::user()->id)->firstOrFail();
    $wishlist->delete();

    return response()->json(['message' => 'Removed from wishlist']);
}

}
