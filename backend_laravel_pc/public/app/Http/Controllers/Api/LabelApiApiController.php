<?php

namespace App\Http\Controllers\Api;

use App\Models\LabelModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\LabelResource;

class LabelApiApiController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $labels = LabelModel::get();

        $labelsresource = LabelResource::collection($labels);
        return $this->sendSuccess($labelsresource, 'Label retrieved successfully');
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
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $label = new LabelModel();
        $label->name = $request->name;
        $label->save();

       return $this->sendSuccess(new LabelResource($label), 'Label created successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $label = LabelModel::with('products')->find($id);


        if (!$label) {

            return $this->sendError('Label not found', '');
        } else {

            return $this->sendSuccess(new LabelResource($label), 'Label retrieved successfully');
        }
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
        $label = LabelModel::find($id);

        if (!$label) {
            return $this->sendError('Label not found', 200);
        } else {
            $request->validate([
                'name' => 'required|string|max:255',
            ]);

            $label->name = $request->name;
            $label->save();

            return $this->sendSuccess(new LabelResource($label), 'Label updated successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $label = LabelModel::find($id);

        if (!$label) {
            return $this->sendError('Label not found', 200);
        } else {
            $label->delete();
            return $this->sendSuccess('', 'Label deleted successfully');
        }
    }
}
