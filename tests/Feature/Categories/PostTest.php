<?php

namespace Tests\Feature\Categories;

use App\Models\Category;
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
     * @var array
     */
    protected array $new_category;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->category = Category::factory()->state(['category_id' => null])->create();
        $this->new_category['title'] = $this->faker->sentence();
        $this->new_category['category_id'] = 1;
        $this->new_category['picture'] = UploadedFile::fake()->image('file.jpg', 600, 600);
    }

    /**
     * @return void
     */
    public function test_successful_category_creation(): void
    {
        $this->assertDatabaseMissing('categories', [
            'category_id' => $this->new_category['category_id'],
            'title' => $this->new_category['title']
        ]);
        Passport::actingAs($this->user, [route('admin.categories.store')]);
        $res = $this->postJson(route('admin.categories.store'), $this->new_category);
        $res->assertStatus(201);
        $this->assertDatabaseHas('categories', [
            'category_id' => $this->new_category['category_id'],
            'title' => $this->new_category['title']
        ]);
    }

    /**
     * @return void
     */
    public function test_unable_to_create_categories_error_not_authorized(): void
    {
        $this->assertDatabaseMissing('categories', [
            'category_id' => $this->new_category['category_id'],
            'title' => $this->new_category['title']
        ]);
        $res = $this->postJson(route('admin.categories.store'), $this->new_category);
        $res->assertStatus(401);
        $this->assertDatabaseMissing('categories', [
            'category_id' => $this->new_category['category_id'],
            'title' => $this->new_category['title']
        ]);
    }

    /**
     * @return void
     */
    public function test_unable_to_create_categories_title_required_error(): void
    {
        $this->new_category['title'] = '';
        $this->assertDatabaseMissing('categories', [
            'category_id' => $this->new_category['category_id'],
            'title' => $this->new_category['title']
        ]);
        Passport::actingAs($this->user, [route('admin.categories.store')]);
        $res = $this->postJson(route('admin.categories.store'), $this->new_category);
        $res->assertStatus(422);
        $res->assertJsonStructure([
            'errors' => [
                'title'
            ]
        ]);
        $this->assertDatabaseMissing('categories', [
            'category_id' => $this->new_category['category_id'],
            'title' => $this->new_category['title']
        ]);
    }

    /**
     * @return void
     */
    public function test_unable_to_create_categories_category_no_exists_error(): void
    {
        $this->new_category['category_id']++;
        $this->assertDatabaseMissing('categories', [
            'category_id' => $this->new_category['category_id'],
            'title' => $this->new_category['title']
        ]);
        Passport::actingAs($this->user, [route('admin.categories.store')]);
        $res = $this->postJson(route('admin.categories.store'), $this->new_category);
        $res->assertStatus(422);
        $res->assertJsonStructure([
            'errors' => [
                'category_id'
            ]
        ]);
        $this->assertDatabaseMissing('categories', [
            'category_id' => $this->new_category['category_id'],
            'title' => $this->new_category['title']
        ]);
    }
}
