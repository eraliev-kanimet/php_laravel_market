<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductShowResource extends JsonResource
{
    /**
     * @param $request
     * @return array
     */
    public function toArray($request): array
    {
        $images = [];
        foreach ($this->resource->images as $image) $images[] = asset($image);
        return [
            'id' => $this->resource->id,
            'title' => $this->resource->title,
            'desc' => $this->resource->desc,
            'manufacturer' => $this->resource->manufacturer,
            'category_id' => $this->resource->category_id,
            'price' => $this->resource->price,
            'count' => $this->resource->count,
            'images' => $images,
            'properties' => $this->resource->properties,
        ];
    }
}
