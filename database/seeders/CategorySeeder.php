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
        Category::factory()->state(['category_id' => null])->count(10)->create();
        Category::factory()->count(20)->state(['category_id' => rand(1, 10)])->create();
        Category::factory()->count(20)->state(['category_id' => rand(1, 29)])->create();
    }
}
