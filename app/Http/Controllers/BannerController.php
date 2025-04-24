<?php

namespace App\Http\Controllers;

use App\Models\BannerModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        $banners = BannerModel::get();
        return view('admin.banner.index', compact('banners'));

    }
    public function create()
    {
        return view('admin.banner.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Store the banner in the database
        // Assuming you have a Banner model and a banners table
        $banner = new BannerModel();
        $banner->title = $request->input('title');
        $banner->description = $request->input('description');
        $image_Path = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image_Path = $image->storeAs('images/banner', $imageName, 'public');

        }
        $banner->image = $image_Path;
        $banner->save();

        return redirect()->route('admin.banner')->with('success', 'Banner created successfully.');
    }
    public function destroy($id){
        // Find the banner by ID
        $banner = BannerModel::find($id);

        if ($banner) {
            // Delete the banner from the database
            $banner->delete();
            return redirect()->route('admin.banner')->with('success', 'Banner deleted successfully.');
        } else {
            return redirect()->route('admin.banner')->with('error', 'Banner not found.');
        }
    }
    public function edit($id)
    {
        $banner = BannerModel::find($id);
        return view('admin.banner.edit', compact('banner'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Find the banner by ID
        $banner = BannerModel::find($id);

        if ($banner) {
            // Update the banner details
            $banner->title = $request->input('title');
            $banner->description = $request->input('description');

            $image_Path=null;
            if ($request->hasFile('image')) {
             // Delete old image if it exists
             if ($banner->image) {
                 Storage::disk('public')->delete($banner->image);
             }

             // Upload the new image
             $image = $request->file('image');
             $imageName = time() . '.' . $image->getClientOriginalExtension();
             $image_Path = $image->storeAs('images/banner', $imageName, 'public');
            //  $banner->image = $image_Path;
             } else {
                 // Keep the old image path if no new image is uploaded
                 $image_Path = $banner->image;

             }
            // Update the banner in the database
            $banner->update([
                'title' => $request->title,
                'description' => $request->description,
                'image' => $image_Path??'',
            ]);


            return redirect()->route('admin.banner')->with('success', 'Banner updated successfully.');
        } else {
            return redirect()->route('admin.banner')->with('error', 'Banner not found.');
        }
    }

}
