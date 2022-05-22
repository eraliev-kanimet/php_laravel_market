<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'title' => 'bail|required|string|max:64',
            'picture' => 'bail|nullable|image',
            'category_id' => 'bail|nullable|numeric|exists:App\Models\Category,id',
            'picture_remove' => 'bail|nullable|string'
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Поле название обязательно!',
            'category_id.required' => 'Поле категория обязательно!'
        ];
    }
}
// <products-header/>
// <products-table/>
// <base-sidebar :active="product">
//   <product-form/>
// </base-sidebar>
// this.receiptOfProducts();
// receiptOfProducts: 'products/receiptOfProducts'
// product: state => state.products.sidebar
// import {productModule} from "@/store/productModule";
// products: productModule