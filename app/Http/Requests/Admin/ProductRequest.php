<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'title' => 'bail|required|string|max:128',
            'category_id' => 'bail|required|numeric|exists:App\Models\Category,id',
            'desc' => 'bail|nullable|string|max:1024',
            'manufacturer' => 'bail|required|string|max:64',
            'properties' => 'bail|nullable|array',
            'count' => 'bail|required|numeric|max:1000',
            'price' => 'bail|required|numeric|max:10000',
            'changed_images' => 'bail|nullable|boolean',
            'removed_images' => 'bail|nullable|array',
            'image1' => 'bail|nullable|image',
            'image2' => 'bail|nullable|image',
            'image3' => 'bail|nullable|image',
            'image4' => 'bail|nullable|image'
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Поле название обязательно',
            'category_id.required' => 'Поле категория обязательно'
        ];
    }
}
