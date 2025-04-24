<?php

namespace App\Http\Controllers;

use App\Models\LabelModel;
use App\Models\ProductModel;
use Illuminate\Http\Request;
use App\Models\CategoryModel;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
   public function index()
   {
        $products = ProductModel::get();
        $categories = CategoryModel::all();
        return view('admin.product.index', compact('products','categories'));
   }
   public function create()
   {
        $categories = CategoryModel::all();
        $labels = LabelModel::all();
        return view('admin.product.create', compact('categories','labels'));
   }
   public function store(Request $request)
   {


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
        $labelId = $request->input('label_id');  // Retrieve 'label_id' input (nullable)
        // $productImage = $request->file('product_image');  // Retrieve uploaded 'product_image'


     // Handle image upload (if a file was uploaded)
          // Handle image upload (if present)

          if ($request->hasFile('product_image')) {
            $imagefile = $request->file('product_image');
            $imageName = time() . '.' . $imagefile->getClientOriginalExtension();
            $image_Path = $imagefile->storeAs('images/product', $imageName, 'public');

          }

    // Create a new product record
    ProductModel::create([
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
        'product_image' => $image_Path ?? '',  // Save the image path if uploaded
    ]);
    return redirect()->route('admin.product');
   }
    public function edit($id)
    {
          $product = ProductModel::find($id);
          $categories = CategoryModel::get();
          $labels = LabelModel::get();
          return view('admin.product.edit', compact('product','categories','labels'));
    }
    public function update(Request $request, $id)
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
                'product_image' => $image_Path,  // Save the image path if uploaded
            ]);
            return redirect()->route('admin.product')->with('success', 'Product updated successfully');
        }else{
            return back()->with('error', 'Product not found');
        }

    }

    public function destroy($id)
    {
        $product = ProductModel::find($id);

        if($product)
        {
            // Delete the product image if it exists
            if ($product->product_image && File::exists(public_path('images/' . $product->product_image))) {
                File::delete(public_path('images/' . $product->product_image));
            }

            // Delete the product record
            $product->delete();
            return redirect()->route('admin.product')->with('success', 'Product deleted successfully');
        }else
        {
            return back()->with('error', 'Product not found');
        }
    }

    public function filter(Request $request)
    {
        // Get the category filter from the query string
        $search = $request->input('search');
        $category_id = $request->input('category_id');
        $ram = $request->input('ram');
        $price_range = $request->input('price'); // Get price range

        // Start building the query for products
        $products = ProductModel::query();

        // Apply search filter if the search term is provided
        if (!empty($search)) {
            $products->where('product_name', 'LIKE', "%{$search}%");
        }
        // Apply category filter if a category is selected
        if (!empty($category_id)) {
            $products->where('category_id', $category_id);
        }
        // Apply RAM filter if a RAM is selected
        if (!empty($ram)) {
            $products->where('RAM', 'LIKE', "%{$ram}%"); // Partial match for RAM
        }
        // Apply price filter
        if (!empty($price_range)) {
            // Extract min and max values from the selected price range
            [$min_price, $max_price] = explode('-', $price_range);
            $products->whereBetween('product_price', [(int)$min_price, (int)$max_price]);
        }

        // Paginate the results, you can adjust the perPage number as needed
        $products = $products->get();

        // Get all categories for the filter dropdown
        $categories = CategoryModel::all();

        // Return the view with the filtered products and categories
        return view('admin.product.index', compact('products', 'categories', 'search', 'category_id','ram'));
    }

}
