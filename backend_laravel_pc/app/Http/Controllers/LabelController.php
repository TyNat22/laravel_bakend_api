<?php

namespace App\Http\Controllers;

use App\Models\LabelModel;
use Illuminate\Http\Request;

class LabelController extends Controller
{
    public function index(){
        $labels =  LabelModel::get();
        return view('admin.label.index',compact('labels'));
    }
    public function show($id){
        $label =  LabelModel::with('products')->find($id);
        return view('admin.label.show',compact('label'));
    }
    public function create(){
        return view('admin.label.create');
    }
    public function store(Request $request){
        $name = $request->input('name');

        $labelname = LabelModel::create([
            'name' => $name
        ]);

        if($labelname){
            return redirect()->route('admin.label');
        }
    }
    public function edit($id)
    {
        $label = LabelModel::find($id);
        return view('admin.label.edit',compact('label'));

    }
    public function update(Request $request,$id)
    {
        $label = LabelModel::find($id);
        if($label){
            $name = $request->input('name');

            $labelname = $label -> update([
                'name' => $name
            ]);

            if($labelname){
                return redirect()->route('admin.label')->with('success', 'Label update successfully');
            }
        }

    }
    public function destroy($id)
    {
        $label = LabelModel::find($id);

        if($label){
            $label -> delete();
            return back()->with('success', 'Label deleted successfully');
        }
        return back()->with('error', 'Label not found');

    }
}
