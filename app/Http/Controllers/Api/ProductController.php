<?php

namespace App\Http\Controllers\Api;

use App\Models\ProductModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\ProductResources;
use App\Models\CategoryModel;

class ProductController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = ProductModel::get();

        // $products->transform(function ($product) {
        //     if ($product->product_image) {
        //         $product->product_image = url(Storage::url($product->product_image));
        //     }
        // return $product;
        // });

        $resource = ProductResources::collection($products);
       return $this->sendSuccess($resource, 'Product retrieved successfully');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     'product_name' => 'required|string|max:255',
        //     'CPU' => 'required|string|max:255',
        //     'RAM' => 'required|string|max:255',
        //     'storage' => 'required|string|max:255',
        //     'VGA' => 'required|string|max:255',
        //     'SCREEN' => 'required|string|max:255',
        //     'product_rating' => 'required|numeric|min:0|max:5',
        //     'product_price' => 'required|numeric|min:0',
        //     'OS' => 'required|string|max:255',
        //     'category_id' => 'required|exists:categories,id',
        //     'label_id' => 'nullable|exists:labels,id', // Nullable, so it can be empty
        //     'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Nullable validation for image
        // ]);

        // $product = new ProductModel();
        // $product->fill($request->all());

        // if ($request->hasFile('product_image')) {
        //     $imageFile = $request->file('product_image');
        //     $imageName = time() . '.' . $imageFile->getClientOriginalExtension();
        //     $imagePath = $imageFile->storeAs('images/product', $imageName, 'public');
        //     $product->product_image = $imagePath;
        // }

        // $product->save();

        // return response()->json([
        //     'message' => 'Product created successfully',
        //     'product' => $product
        // ], 201);
        $data = $request->all();
        $products = ProductModel::create($data);
        $res = new ProductResources($products);
        return $this->sendSuccess($res, 'Product created successfully');

    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $products = ProductModel::find($id);

        if ($products->product_image) {
            $products->product_image = url(Storage::url($products->product_image));
        }
        // $products->transform(function ($product) {
        //     if ($product->product_image) {
        //         $product->product_image = url(Storage::url($product->product_image));
        //     }
        // return $product;
        // });
        return response()->json([
            'msg'=>'Product retrieved successfully',
            'product' => $products
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = ProductModel::find($id);

        if($product){

            $productName = $request->input('product_name');  // Retrieve 'product_name' input
            $cpu = $request->input('CPU');  // Retrieve 'CPU' input
            $ram = $request->input('RAM');  // Retrieve 'RAM' input
            $storage = $request->input('storage');  // Retrieve 'storage' input
            $vga = $request->input('VGA');  // Retrieve 'VGA' input
            $screen = $request->input('SCREEN');  // Retrieve 'SCREEN' input
            $productRating = $request->input('product_rating');  // Retrieve 'product_rating' input
            $productPrice = $request->input('product_price');  // Retrieve 'product_price' input
            $os = $request->input('OS');  // Retrieve 'OS' input
            $categoryId = $request->input('category_id');  // Retrieve 'category_id' input
            $labelId = $request->input('label_id');

            $image_Path = null;
            if ($request->hasFile('product_image'))
            {
                if ($product->product_image) {
                    Storage::disk('public')->delete($product->product_image);
                }

                // Upload the new image
                $imagefile = $request->file('product_image');
                $imageName = time() . '.' . $imagefile->getClientOriginalExtension();
                $image_Path = $imagefile->storeAs('images/product', $imageName, 'public');
            } else {
                $image_Path = $product->product_image;
            }

            // Update the product record
            $product->update([
                'product_name' => $productName,
                'CPU' => $cpu,
                'RAM' => $ram,
                'storage' => $storage,
                'VGA' => $vga,
                'SCREEN' => $screen,
                'product_rating' => $productRating,
                'product_price' => $productPrice,
                'OS' => $os,
                'category_id' => $categoryId,
                'label_id' => $labelId,
                'product_image' => $image_Path??'',  // Save the image path if uploaded
            ]);
            return response()->json([
                'message' => 'Product updated successfully',
                'product' => $product
            ]);
        }else{
            return response()->json([
                'message' => 'Product not found'
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = ProductModel::find($id);

        if ($product) {
            // Delete the image file from the public folder, if it exists
            if ($product->product_image && Storage::disk('public')->exists($product->product_image)) {
                Storage::disk('public')->delete($product->product_image);
            }

            // Delete the product from the database
            $product->delete();

            return response()->json([
                'message' => 'Product deleted successfully'
            ]);
        }

        return response()->json([
            'message' => 'Product not found'
        ], 404);
    }
}
