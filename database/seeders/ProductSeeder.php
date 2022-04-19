<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run()
    {
        Product::factory()->count(600)->create();
        $categories = Category::all();
        foreach ($categories as $category) {
            $category->update(['products_count' => $category->products->count()]);
        }
    }
}
