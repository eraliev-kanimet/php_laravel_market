<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\CategoryShowResource;
use App\Http\Resources\SubcategoriesResource;
use App\Models\Category;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class CategoriesController extends Controller
{
    /**
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $categories = Category::whereNull('category_id')->get();
        return CategoryResource::collection($categories);
    }

    /**
     * @param Request $request
     * @return Response|Application|ResponseFactory
     */
    public function store(Request $request): Response|Application|ResponseFactory
    {
        return response('ok', 200);
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
     * @param Category $category
     * @return SubcategoriesResource
     */
    public function subcategories(Category $category): SubcategoriesResource
    {
        return new SubcategoriesResource($category);
    }

    /**
     * @param Request $request
     * @param Category $category
     * @return Response|Application|ResponseFactory
     */
    public function update(Request $request, Category $category): Response|Application|ResponseFactory
    {
        return response('ok', 200);
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
