<?php

namespace App\Http\AdminControllers;

use App\Http\Requests\Admin\CategoryRequest;
use App\Http\Resources\Admin\CategoryResource;
use App\Http\Resources\Admin\CategoryShowResource;
use App\Models\Category;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CategoriesController extends AdminController
{
    /**
     * @return AnonymousResourceCollection
     * @throws AuthorizationException
     */
    public function index(): AnonymousResourceCollection
    {
        $this->authorize('createOrUpdateOrDeleteOrGetCategories', Auth::user());
        return CategoryResource::collection(Category::whereNull('category_id')->get());
    }

    /**
     * @return AnonymousResourceCollection
     * @throws AuthorizationException
     */
    public function all(): AnonymousResourceCollection
    {
        $this->authorize('createOrUpdateOrDeleteOrGetCategories', Auth::user());
        return CategoryResource::collection(Category::all());
    }

    /**
     * @param CategoryRequest $request
     * @return Response|Application|ResponseFactory
     * @throws AuthorizationException
     */
    public function store(CategoryRequest $request): Response|Application|ResponseFactory
    {
        $this->authorize('createOrUpdateOrDeleteOrGetCategories', Auth::user());
        $data = $request->all();
        if ($request->hasFile('picture')) $data['picture'] = $this->saveImage($request->file('picture'));
        $category = new Category($data);
        $category->save();
        return response([], 201);
    }

    /**
     * @param Category $category
     * @return CategoryShowResource
     * @throws AuthorizationException
     */
    public function show(Category $category): CategoryShowResource
    {
        $this->authorize('createOrUpdateOrDeleteOrGetCategories', Auth::user());
        return new CategoryShowResource($category);
    }

    /**
     * @param CategoryRequest $request
     * @param Category $category
     * @return Response|Application|ResponseFactory
     * @throws AuthorizationException
     */
    public function update(CategoryRequest $request, Category $category): Response|Application|ResponseFactory
    {
        $this->authorize('createOrUpdateOrDeleteOrGetCategories', Auth::user());
        $data = $request->all();
        if ($request->has('picture_remove')) $data['picture'] = '';
        if ($request->hasFile('picture')) $data['picture'] = $this->saveImage($request->file('picture'));
        if ($request->has('category_id')) if ($category->id == $request->input('category_id')) $data['category_id'] = null;
        $category->update($data);
        return response([], 200);
    }

    /**
     * @param Category $category
     * @return Response|Application|ResponseFactory
     * @throws AuthorizationException
     */
    public function destroy(Category $category): Response|Application|ResponseFactory
    {
        $this->authorize('createOrUpdateOrDeleteOrGetCategories', Auth::user());
        $category->delete();
        return response([], 204);
    }
}
