<?php

namespace Tests\Feature\Admin\Products;

use App\Models\Category;
use App\Models\Product;
use Laravel\Passport\Passport;
use Tests\TestCase;

class GetTest extends TestCase
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
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        Category::factory()->state(['category_id' => null])->create();
        Product::factory()->state(['category_id' => 1])->count(5)->create();
        $this->category = Category::find(1);
        $this->product = Product::find(1);
    }

    /**
     * @return void
     */
    public function test_successfully_received_the_products(): void
    {
        Passport::actingAs($this->user, [route('admin.products.index')]);
        $res = $this->getJson(route('admin.products.index'));
        $res->assertStatus(200);
        $res->assertJsonStructure([
            'data' => [
                [
                    'id',
                    'title',
                    'category_id',
                    'price',
                    'count',
                    'picture'
                ]
            ]
        ]);
    }

    /**
     * @return void
     */
    public function test_failed_to_receive_products_not_authorized(): void
    {
        $res = $this->getJson(route('admin.products.category'));
        $res->assertStatus(401);
    }

    /**
     * @return void
     */
    public function test_successfully_received_category_products(): void
    {
        Passport::actingAs($this->user, [route('admin.products.category')]);
        $res = $this->call('GET', route('admin.products.category'), ['category_id' => $this->category->id]);
        $res->assertStatus(200);
        $res->assertJsonStructure([
            'data' => [
                [
                    'id',
                    'title',
                    'category_id',
                    'price',
                    'count',
                    'picture'
                ]
            ]
        ]);
    }

    /**
     * @return void
     */
    public function test_not_successfully_received_category_products_error_not_authorized(): void
    {
        $res = $this->getJson(route('admin.products.category'), ['category_id' => $this->category->id]);
        $res->assertStatus(401);
    }

    /**
     * @return void
     */
    public function test_not_successfully_received_category_products_error_category_no_exists(): void
    {
        Passport::actingAs($this->user, [route('admin.products.category')]);
        $res = $this->call('GET', route('admin.products.category'), ['category_id' => 2000]);
        $res->assertStatus(302);
    }

    /**
     * @return void
     */
    public function test_product_received_successfully(): void
    {
        Passport::actingAs($this->user, [route('admin.products.show', $this->product)]);
        $res = $this->getJson(route('admin.products.show', $this->product));
        $res->assertStatus(200);
        $res->assertJsonStructure([
            'data' => [
                'id',
                'title',
                'desc',
                'manufacturer',
                'category_id',
                'price',
                'count',
                'images',
                'properties'
            ]
        ]);
    }

    /**
     * @return void
     */
    public function test_the_product_was_not_successfully_received_error_not_authorized(): void
    {
        $res = $this->getJson(route('admin.products.show', $this->product));
        $res->assertStatus(401);
    }
}
