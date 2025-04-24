<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoryModel;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function category()
    {
        $categories = CategoryModel::get();
        return view('admin.category.index', compact('categories'));

    }
    public function show($id)
    {
        $category = CategoryModel::with('products')->find($id);
        return view('admin.category.show',compact('category'));
    }
    public function create()
    {
        return view('admin.category.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Retrieve form data
        $name = $request->input('name');
        $description = $request->input('description');

        // Handle image upload (if present)
        $image_Path = null;
        if ($request->hasFile('image')) {
            $imagefile = $request->file('image');
            $imageName = time() . '.' . $imagefile->getClientOriginalExtension();
            $image_Path = $imagefile->storeAs('images', $imageName, 'public');
        }
        // Save data to database
        CategoryModel::create([
            'name' => $name,
            'description' => $description,
            'image' =>  $image_Path ?? '',
        ]);

        return redirect()->route('admin.category')->with('success', 'Category created successfully');



    }
    public function destory($id)
    {
        // Find the category by ID
        $category = CategoryModel::find($id);

        if ($category) {
            // Delete the image file from the public folder, if it exists
            if ($category->image && File::exists(public_path('images/' . $category->image))) {
                File::delete(public_path('images/' . $category->image));
            }

            // Delete the category from the database
            $category->delete();

            return back()->with('success', 'Category deleted successfully');
        }

        return back()->with('error', 'Category not found');
    }

    public function edit($id)
    {
        $category = CategoryModel::find($id);

        if(!$category){
            return back()->with('error', 'Category not found');
        }
        return view('admin.category.edit', compact('category'));
    }
    public function update(Request $request,$id)
    {
        $category = CategoryModel::find($id);

        if(!$category){
            return back()->with('error', 'Category not found');
        }
        //validate the form data
        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
           // Handle new image upload (if present)
           $image_Path=null;
           if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }

            // Upload the new image
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image_Path = $image->storeAs('images', $imageName, 'public');
            } else {
                // Keep the old image path if no new image is uploaded
                $image_Path = $category->image;
            }
        // Update the category in the database
        $category->update([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $image_Path??'',
        ]);
        return redirect()->route('admin.category')->with('success', 'Category update successfully');;
    }

    //




}
