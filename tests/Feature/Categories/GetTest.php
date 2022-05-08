<?php

namespace Tests\Feature\Categories;

use App\Models\Category;
use Laravel\Passport\Passport;
use Tests\TestCase;

class GetTest extends TestCase
{
    /**
     * @var Category
     */
    protected Category $category;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        Category::factory()->state(['category_id' => null])->count(5)->create();
        Category::factory()->state(['category_id' => 1])->count(5)->create();
        $this->category = Category::find(1);
    }

    /**
     * @return void
     */
    public function test_successfully_getting_categories_with_category_id_properties_null(): void
    {
        Passport::actingAs($this->user, [route('admin.categories.index')]);
        $res = $this->getJson(route('admin.categories.index'));
        $res->assertStatus(200);
        $res->assertJsonStructure([
            'data' => [
                [
                    'id',
                    'title',
                    'category_id',
                    'picture'
                ]
            ]
        ]);
    }

    /**
     * @return void
     */
    public function test_unable_to_get_categories_with_category_id_properties_null(): void
    {
        $res = $this->getJson(route('admin.categories.index'));
        $res->assertStatus(401);
    }

    /**
     * @return void
     */
    public function test_successfully_getting_all_categories(): void
    {
        Passport::actingAs($this->user, [route('admin.categories.all')]);
        $res = $this->getJson(route('admin.categories.all'));
        $res->assertStatus(200);
        $res->assertJsonStructure([
            'data' => [
                [
                    'id',
                    'title',
                    'category_id',
                    'picture'
                ]
            ]
        ]);
    }

    /**
     * @return void
     */
    public function test_unable_to_get_all_categories(): void
    {
        $res = $this->getJson(route('admin.categories.all'));
        $res->assertStatus(401);
    }

    /**
     * @return void
     */
    public function test_unable_to_get_category_categories(): void
    {
        Passport::actingAs($this->user, [route('admin.categories.show', $this->category)]);
        $res = $this->getJson(route('admin.categories.show', $this->category));
        $res->assertStatus(200);
        $res->assertJsonStructure([
            'data' => [
                [
                    'id',
                    'title',
                    'category_id',
                    'picture'
                ]
            ],
            'category' => [
                'id',
                'title',
                'category_id',
                'picture'
            ]
        ]);
    }

    /**
     * @return void
     */
    public function test_not_successfully_getting_categories_with_category(): void
    {
        $res = $this->getJson(route('admin.categories.show', $this->category));
        $res->assertStatus(401);
    }
}
