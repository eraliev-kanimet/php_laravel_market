<?php

namespace Tests\Feature\Admin\Products;

use App\Models\Category;
use App\Models\Product;
use Laravel\Passport\Passport;
use Tests\TestCase;

class DeleteTest extends TestCase
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
        $this->category = Category::factory()->state(['category_id' => null])->create();
        $this->product = Product::factory()->state(['category_id' => $this->category->id])->create();
    }

    /**
     * @return void
     */
    public function test_successful_deletion_of_product(): void
    {
        $this->assertDatabaseHas('products', [
            'id' => $this->product->id,
            'category_id' => $this->product->category_id,
            'title' => $this->product->title,
            'manufacturer' => $this->product->manufacturer,
            'desc' => $this->product->desc,
            'count' => $this->product->count,
            'price' => $this->product->price,
            'images' => json_encode($this->product->images),
            'properties' => json_encode($this->product->properties)
        ]);
        Passport::actingAs($this->user, [route('admin.products.destroy', $this->product)]);
        $res = $this->deleteJson(route('admin.products.destroy', $this->product));
        $res->assertStatus(204);
        $this->assertDatabaseMissing('categories', [
            'id' => $this->product->id,
            'category_id' => $this->product->category_id,
            'title' => $this->product->title,
            'manufacturer' => $this->product->manufacturer,
            'desc' => $this->product->desc,
            'count' => $this->product->count,
            'price' => $this->product->price,
            'images' => json_encode($this->product->images),
            'properties' => json_encode($this->product->properties)
        ]);
    }

    /**
     * @return void
     */
    public function test_unable_to_delete_categories_error_not_authorized(): void
    {
        $this->assertDatabaseHas('products', [
            'id' => $this->product->id,
            'category_id' => $this->product->category_id,
            'title' => $this->product->title,
            'manufacturer' => $this->product->manufacturer,
            'desc' => $this->product->desc,
            'count' => $this->product->count,
            'price' => $this->product->price,
            'images' => json_encode($this->product->images),
            'properties' => json_encode( $this->product->properties)
        ]);
        $res = $this->deleteJson(route('admin.products.destroy', $this->category));
        $res->assertStatus(401);
        $this->assertDatabaseHas('products', [
            'id' => $this->product->id,
            'category_id' => $this->product->category_id,
            'title' => $this->product->title,
            'manufacturer' => $this->product->manufacturer,
            'desc' => $this->product->desc,
            'count' => $this->product->count,
            'price' => $this->product->price,
            'images' => json_encode($this->product->images),
            'properties' => json_encode($this->product->properties)
        ]);
    }
}
