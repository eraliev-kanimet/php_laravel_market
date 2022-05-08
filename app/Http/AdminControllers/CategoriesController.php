<?php

namespace App\Http\AdminControllers;

use App\Http\Requests\Admin\CategoryRequest;
use App\Http\Resources\Admin\CategoryResource;
use App\Http\Resources\Admin\CategoryShowResource;
use App\Models\Category;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class CategoriesController extends AdminController
{
    /**
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return CategoryResource::collection(Category::whereNull('category_id')->get());
    }

        /**
     * @return AnonymousResourceCollection
     */
    public function getAll(): AnonymousResourceCollection
    {
        return CategoryResource::collection(Category::all());
    }

    /**
     * @param CategoryRequest $request
     * @return Response|Application|ResponseFactory
     */
    public function store(CategoryRequest $request): Response|Application|ResponseFactory
    {
        $data = $request->all();
        if ($request->hasFile('picture')) $data['picture'] = $this->saveImage($request->file('picture'));
        $category = new Category($data);
        $category->save();
        return response([], 201);
    }

    /**
     * @param Category $category
     * @return CategoryShowResource
     */
    public function show(Category $category): CategoryShowResource
    {
        return new CategoryShowResource($category);
    }

    /**
     * @param CategoryRequest $request
     * @param Category $category
     * @return Response|Application|ResponseFactory
     */
    public function update(CategoryRequest $request, Category $category): Response|Application|ResponseFactory
    {
        $data = $request->all();
        if ($request->has('picture_remove')) $data['picture'] = '';
        if ($request->hasFile('picture')) $data['picture'] = $this->saveImage($request->file('picture'));
        if ($request->has('category_id')) if ($category->category_id == $request->input('category_id')) $data['category_id'] = null;
        $category->update($data);
        return response([], 200);
    }

    /**
     * @param Category $category
     * @return Response|Application|ResponseFactory
     */
    public function destroy(Category $category): Response|Application|ResponseFactory
    {
        $category->delete();
        return response([], 204);
    }
}
