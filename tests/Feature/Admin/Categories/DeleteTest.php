<?php

namespace Tests\Feature\Admin\Categories;

use App\Models\Category;
use Laravel\Passport\Passport;
use Tests\TestCase;

class DeleteTest extends TestCase
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
        $this->category = Category::factory()->state(['category_id' => null])->create();;
    }

    /**
     * @return void
     */
    public function test_successful_deletion_of_category(): void
    {
        $this->assertDatabaseHas('categories', [
            'id' => $this->category->id,
            'category_id' => $this->category->category_id,
            'title' => $this->category->title,
            'picture' => $this->category->picture
        ]);
        Passport::actingAs($this->user, [route('admin.categories.destroy', $this->category)]);
        $res = $this->deleteJson(route('admin.categories.destroy', $this->category));
        $res->assertStatus(204);
        $this->assertDatabaseMissing('categories', [
            'id' => $this->category->id,
            'category_id' => $this->category->category_id,
            'title' => $this->category->title,
            'picture' => $this->category->picture
        ]);
    }

    /**
     * @return void
     */
    public function test_unable_to_delete_categories_error_not_authorized(): void
    {
        $this->assertDatabaseHas('categories', [
            'id' => $this->category->id,
            'category_id' => $this->category->category_id,
            'title' => $this->category->title,
            'picture' => $this->category->picture
        ]);
        $res = $this->deleteJson(route('admin.categories.destroy', $this->category));
        $res->assertStatus(401);
        $this->assertDatabaseHas('categories', [
            'id' => $this->category->id,
            'category_id' => $this->category->category_id,
            'title' => $this->category->title,
            'picture' => $this->category->picture
        ]);
    }
}
