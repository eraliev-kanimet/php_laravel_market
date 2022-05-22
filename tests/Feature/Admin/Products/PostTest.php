<?php

namespace Tests\Feature\Admin\Products;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Laravel\Passport\Passport;
use Tests\TestCase;

class PostTest extends TestCase
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
        $this->category = Category::factory()->state(['category_id' => null])->create();
        $this->product = Product::factory()->state(['category_id' => 1])->create();
        $this->data = [
            'title' => 'Product title.',
            'desc' => 'Product description, description, description, description, description.',
            'manufacturer' => 'Product manufacturer',
            'category_id' => $this->category->id,
            'price' => 999,
            'count' => 888,
            'image1' => UploadedFile::fake()->image('file1.jpg', 600, 600),
            'image2' => UploadedFile::fake()->image('file2.jpg', 600, 600),
            'image3' => UploadedFile::fake()->image('file3.jpg', 600, 600),
            'image4' => UploadedFile::fake()->image('file4.jpg', 600, 600),
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
            'changed_properties' => true,
            'changed_images' => true,
        ];
    }

    /**
     * @return void
     */
    public function test_product_successfully_created(): void
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
        Passport::actingAs($this->user, [route('admin.products.store')]);
        $res = $this->postJson(route('admin.products.store'), $this->data);
        $res->assertStatus(201);
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

//    /**
//     * @return void
//     */
//    public function test_failed_to_create_product_error_not_authorized(): void
//    {}
//
//    /**
//     * @return void
//     */
//    public function test_failed_to_create_product_title_is_required(): void
//    {}
//
//    /**
//     * @return void
//     */
//    public function test_failed_to_create_product_category_id_is_required(): void
//    {}
//
//    /**
//     * @return void
//     */
//    public function test_failed_to_create_product_category_id_no_exists(): void
//    {}
//
//    /**
//     * @return void
//     */
//    public function test_failed_to_create_product_manufacturer_is_required(): void
//    {}
//
//    /**
//     * @return void
//     */
//    public function test_failed_to_create_product_price_is_required(): void
//    {}
//
//    /**
//     * @return void
//     */
//    public function test_failed_to_create_product_count_is_required(): void
//    {}
}
