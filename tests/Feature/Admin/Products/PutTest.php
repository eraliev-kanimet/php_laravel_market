<?php

namespace Tests\Feature\Admin\Products;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Laravel\Passport\Passport;
use Tests\TestCase;

class PutTest extends TestCase
{
    /**
     * @var Category
     */
    protected Category $category;

    /**
     * @var Product
     */
    protected Product $product;

    /**
     * @var array
     */
    protected array $data;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        Category::factory()->state(['category_id' => null])->count(2)->create();
        $this->category = Category::find(2);
        $this->product = Product::factory()->state(['category_id' => 1])->create();
        $this->data = [
            'title' => 'Product title.',
            'desc' => 'Product description, description, description, description, description.',
            'manufacturer' => 'Product manufacturer',
            'category_id' => $this->category->id,
            'price' => 999,
            'count' => 888,
            'image1' => UploadedFile::fake()->image('file1.jpg', 600, 600),
            'image3' => UploadedFile::fake()->image('file3.jpg', 600, 600),
            'properties' => [
                json_encode([
                    'title' => 'Property title 1',
                    'value' => 'Property value 1'
                ]),
                json_encode([
                    'title' => 'Property title 2',
                    'value' => 'Property value 2'
                ])
            ],
            'changed_images' => true,
            'removed_images' => [3]
        ];
    }

    /**
     * @return void
     */
    public function test_product_successfully_updated(): void
    {
        $this->assertDatabaseMissing('products', [
            'title' => $this->data['title'],
            'desc' => $this->data['desc'],
            'manufacturer' => $this->data['manufacturer'],
            'category_id' => $this->data['category_id'],
            'price' => $this->data['price'],
            'count' => $this->data['count'],
            'properties' => $this->data['properties']
        ]);
        $this->assertDatabaseHas('products', [
            'title' => $this->product->title,
            'desc' => $this->product->desc,
            'manufacturer' => $this->product->manufacturer,
            'category_id' => $this->product->category_id,
            'price' => $this->product->price,
            'count' => $this->product->count,
            'properties' => json_encode($this->product->properties),
            'images' => json_encode($this->product->images)
        ]);
        Passport::actingAs($this->user, [route('admin.products.update', $this->product)]);
        $res = $this->putJson(route('admin.products.update', $this->product), $this->data);
        $res->assertStatus(200);
        $product = Product::find(json_decode($res->getContent())->id);
        $this->assertDatabaseHas('products', [
            'title' => $product->title,
            'desc' => $product->desc,
            'manufacturer' => $product->manufacturer,
            'category_id' => $product->category_id,
            'price' => $product->price,
            'count' => $product->count,
            'properties' => json_encode($product->properties),
            'images' => json_encode($product->images)
        ]);
    }
}
