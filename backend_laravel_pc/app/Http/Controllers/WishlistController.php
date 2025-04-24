<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ProductModel;
use Illuminate\Http\Request;
use App\Models\WishlistModel;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index(){
        $wishlists = WishlistModel::with(['user', 'product'])->get();
        // Fetch only customers who have at least one favorite product
        // $wishlists = User::with('wishlist.product') // Eager load favourites and their related products
        // ->whereHas('wishlist')  // Only customers with at least one favourite
        // ->get();
        // $wishlists = User::whereHas('wishlist')->with('wishlist')->get();
        return view('admin.wishlist.index', compact('wishlists'));
    }
    public function showUser($userId)
    {
        $user = User::findOrFail($userId);
        $wishlists = WishlistModel::where('user_id', $userId)->with('product')->get();

        return view('admin.wishlist.showUser', compact('user', 'wishlists'));
    }

    public function showProduct($productId)
    {
        $product = ProductModel::findOrFail($productId);
        $wishlists = WishlistModel::where('product_id', $productId)->with('user')->get();

        return view('admin.wishlist.showProduct', compact('product', 'wishlists'));
    }
    public function destroy($id) {
        // return response()->json([
        //     'msg'=>$id
        // ]);
        $wishlist = WishlistModel::find($id);
        if($wishlist){
            $wishlist->delete();

            return redirect()->route('admin.wishlist')->with('success', 'Favourite deleted successfully!');
        }else{
            return response()->json(['msg'=>'not found']);
        }

    }
}
