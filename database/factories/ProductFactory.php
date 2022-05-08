<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ProductFactory extends Factory
{
    /**
     * @return array
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(5),
            'category_id' => rand(1, 70),
            'desc' => $this->faker->text(),
            'manufacturer' => $this->faker->sentence(5),
            'properties' => [
                $this->faker->sentence(5) => $this->faker->sentence(5),
                $this->faker->sentence(5) => $this->faker->sentence(5),
                $this->faker->sentence(5) => $this->faker->sentence(5),
                $this->faker->sentence(5) => $this->faker->sentence(5)
            ],
            'count' => rand(10, 50),
            'price' => rand(10, 50),
            'images' => [
                $this->getImage(rand(1, 20)),
                $this->getImage(rand(1, 20)),
                $this->getImage(rand(1, 20)),
                $this->getImage(rand(1, 20))
            ]
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
        return '/storage/pictures/' . $image_name;
    }
}
