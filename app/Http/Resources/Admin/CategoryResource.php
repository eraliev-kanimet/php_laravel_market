<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * @param $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->resource->id,
            'title' => $this->resource->title,
            'category_id' => $this->resource->category_id,
            'picture' => $this->resource->picture == '' ? '' : asset($this->resource->picture),
            'category' => $this->resource->category_id ? $this->resource->category->title : '',
            'products_count' => $this->resource->products_count
        ];
    }
}
