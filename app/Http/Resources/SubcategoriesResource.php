<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubcategoriesResource extends JsonResource
{
    /**
     * @param $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'data' => CategoryResource::collection($this->resource->categories),
            'category' => new CategoryShowResource($this->resource)
        ];
    }
}
