<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public static $wrap = false;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'category_id' => $this->category_id,
            'slug' => $this->slug,
            'description' => $this->description,
            'image_url' => $this->image? :null,
            'images' => $this->images,
            'price' => $this->price,
            'length'=> $this->length,
            'width' => $this->width,
            'depth' => $this->depth,
            'sitting_height' => $this->sitting_height,
            'hard_eyes' => $this->hard_eyes,
            'main_material'=> $this->main_material,
            'inner_filling_material' => $this->inner_filling_material,
            'created_at' => (new \DateTime($this->created_at))->format('Y-m-d H:i:s'),
            'updated_at' => (new \DateTime($this->updated_at))->format('Y-m-d H:i:s')
        ];
    }
}
