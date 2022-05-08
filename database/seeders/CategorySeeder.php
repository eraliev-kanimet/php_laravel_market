<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * @return void
     */
    public function run()
    {
        $categories = Category::factory()->state(['category_id' => null])->count(10)->create();
        foreach ($categories as $category) {
            Category::factory()->state(['category_id' => $category->id])->count(4)->create();
        }
        Category::factory()->count(20)->create();
    }
}
