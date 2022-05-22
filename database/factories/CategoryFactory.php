<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class CategoryFactory extends Factory
{
    /**
     * @return array
     */
    public function definition(): array
    {
        return [
            'category_id' => rand(1, 50),
            'picture' => $this->getImage(rand(1, 20)),
            'title' => $this->faker->sentence(3)
        ];
    }

    /**
     * @param int $image_number
     * @return string
     */
    private function getImage(int $image_number = 1): string
    {
        $path = storage_path() . '/pictures/' . $image_number . '.jpg';
        $image_name = md5(time()) . '.jpg';
        $resize = Image::make($path)->encode('jpg');
        Storage::disk('public')->put('pictures/' . $image_name, $resize->__toString());
        return 'storage/pictures/' . $image_name;
    }
}
