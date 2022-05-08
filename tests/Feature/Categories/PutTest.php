<?php

namespace Tests\Feature\Categories;

use App\Models\Category;
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
        $this->data['title'] = 'Category title';
        $this->data['category_id'] = 1;
        $this->data['picture'] = UploadedFile::fake()->image('file.jpg', 600, 600);
    }

    /**
     * @return void
     */
    public function test_successful_category_updated(): void
    {
        $this->assertDatabaseHas('categories', [
            'id' => $this->category->id,
            'category_id' => $this->category->category_id,
            'title' => $this->category->title,
            'picture' => $this->category->picture
        ]);
        Passport::actingAs($this->user, [route('admin.categories.update', $this->category)]);
        $res = $this->putJson(route('admin.categories.update', $this->category), $this->data);
        $res->assertStatus(200);
        $this->assertDatabaseHas('categories', [
            'category_id' => $this->data['category_id'],
            'title' => $this->data['title']
        ]);
    }

    /**
     * @return void
     */
    public function test_unable_to_update_categories_error_not_authorized(): void
    {
        $this->assertDatabaseHas('categories', [
            'id' => $this->category->id,
            'category_id' => $this->category->category_id,
            'title' => $this->category->title,
            'picture' => $this->category->picture
        ]);
        $res = $this->putJson(route('admin.categories.update', $this->category), $this->data);
        $res->assertStatus(401);
        $this->assertDatabaseMissing('categories', [
            'category_id' => $this->data['category_id'],
            'title' => $this->data['title'],
        ]);
    }

    /**
     * @return void
     */
    public function test_unable_to_update_categories_title_required_error(): void
    {
        $this->data['title'] = '';
        $this->assertDatabaseHas('categories', [
            'id' => $this->category->id,
            'category_id' => $this->category->category_id,
            'title' => $this->category->title,
            'picture' => $this->category->picture
        ]);
        Passport::actingAs($this->user, [route('admin.categories.update', $this->category)]);
        $res = $this->putJson(route('admin.categories.update', $this->category), $this->data);
        $res->assertStatus(422);
        $res->assertJsonStructure([
            'errors' => [
                'title'
            ]
        ]);
        $this->assertDatabaseMissing('categories', [
            'category_id' => $this->data['category_id'],
            'title' => $this->data['title'],
        ]);
    }

    /**
     * @return void
     */
    public function test_unable_to_update_categories_category_no_exists_error(): void
    {
        $this->data['category_id']++;
        $this->assertDatabaseHas('categories', [
            'id' => $this->category->id,
            'category_id' => $this->category->category_id,
            'title' => $this->category->title,
            'picture' => $this->category->picture
        ]);
        Passport::actingAs($this->user, [route('admin.categories.update', $this->category)]);
        $res = $this->putJson(route('admin.categories.update', $this->category), $this->data);
        $res->assertStatus(422);
        $res->assertJsonStructure([
            'errors' => [
                'category_id'
            ]
        ]);
        $this->assertDatabaseMissing('categories', [
            'category_id' => $this->data['category_id'] + 1,
            'title' => $this->data['title'],
        ]);
    }
}
