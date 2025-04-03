<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\CategoryModel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResources;
use App\Http\Resources\ProductResources;

class CategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories =CategoryModel::get();
        // $categories->transform(function ($category) {
        //     if ($category->image) {
        //         $category->image = url(Storage::url('images/' . $category->image));
        //     }
        // return $category;
        // });
        $res = CategoryResources::collection($categories);
        return $this->sendSuccess($res, 'Category retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' =>'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'image'=> 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $category = new CategoryModel();
        $category->name = $request->name;
        $category->description = $request->description;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $path = $image->storeAs('images', 'public');
            $category->image = $path ?? '';
        }
        $category->save();


        return response()->json([
            'message' => 'Category created successfully',
            'category' => $category
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = CategoryModel::with('products')->find($id);

        if($category){

            $res = ProductResources::collection($category->products);
            return $this->sendSuccess($res, 'Category retrieved successfully');
        }else{
            return $this->sendError('Category not found',201,[]);
        }
        // foreach ($category->products as $product) {
        //     if ($product->product_image) {
        //         $product->product_image = url(Storage::url($product->product_image));
        //     }
        // }


        // return response()->json($category);
        // return $this->sendSuccess($category, 'Category retrieved successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = CategoryModel::find($id);

        if(!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($category->image && Storage::exists('images' . $category->image)) {
                Storage::delete('images' . $category->image);
            }

            // Upload new image
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('images', $imageName,'public');

            $category->image = $imageName;
        }

        $category->update([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $category->image,
        ]);

        return response()->json($category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = CategoryModel::findOrFail($id);
        if ($category->image) {
            Storage::delete('images/' . $category->image);
        }
        $category->delete();
        return response()->json([
            'message' => 'Category deleted successfully'
        ]);
    }
}
