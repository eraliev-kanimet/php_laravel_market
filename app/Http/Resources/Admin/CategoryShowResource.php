<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryShowResource extends JsonResource
{
    /**
     * @param $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'data' => CategoryResource::collection($this->resource->categories),
            'category' => new CategoryResource($this->resource)
        ];
    }
}
