<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' =>$this->id,
            'product_name' => $this->product_name,
            'CPU' => $this->CPU,
            'RAM' =>$this->RAM,
            'storage' => $this->storage,
            'VGA' => $this->VGA,
            'SCREEN' => $this->SCREEN,
            'product_rating' => $this->product_rating,
            'product_price' => $this->id,
            'OS' => $this->OS,
            'category_id' => $this->category_id,
            'label_id' => $this->label_id,
            'product_image' => $this->product_image ? url(Storage::url($this->product_image)) : null,

        ];
    }
}
