<?php

namespace App\Http\Controllers\Api;

use App\Models\BannerModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BannerResource;
use Illuminate\Support\Facades\Storage;

class BannerApiController extends ApiController
{
    public function index(){
        $banners = BannerModel::get();

        $banner = BannerResource::collection($banners);

        return $this->sendSuccess($banner, 'Banner retrieved successfully');
    }
   public function update(Request $request,$id){

        $banner = BannerModel::find($id);

        if (!$banner) {
            return $this->sendError('Banner not found','',);
        }else{
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Nullable validation for image
            ]);

            if ($request->hasFile('image')) {
                if ($banner->image) {
                    Storage::delete($banner->image);
                }
                $banner->image = $request->file('image')->store('banners');
            }

            $banner->title = $request->input('title');
            $banner->description = $request->input('description');
            $banner->save();

            return $this->sendSuccess(new BannerResource($banner), 'Banner updated successfully');
        }

   }
   public function store(Request $request){
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Nullable validation for image
        ]);

        $banner = new BannerModel();

        if ($request->hasFile('image')) {
            $banner->image = $request->file('image')->store('banners');
        }

        $banner->title = $request->input('title');
        $banner->description = $request->input('description');
        $banner->save();

        return $this->sendSuccess(new BannerResource($banner), 'Banner created successfully');
   }
   public function destroy($id){
    $banner = BannerModel::find($id);
        if(!$banner){
            return $this->sendError('banner not found',201);
        }else{
            if ($banner->image) {
                Storage::delete($banner->image);
            }
            $banner->delete();
            return $this->sendSuccess([], 'Banner deleted successfully');
        }
   }
}
