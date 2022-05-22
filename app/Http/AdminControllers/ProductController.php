<?php

namespace App\Http\AdminControllers;

use App\Http\Requests\Admin\ProductRequest;
use App\Http\Resources\Admin\ProductResource;
use App\Http\Resources\Admin\ProductShowResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class ProductController extends AdminController
{
    /**
     * @return AnonymousResourceCollection
     * @throws AuthorizationException
     */
    public function index(): AnonymousResourceCollection
    {
        $this->authorize('createOrUpdateOrDeleteOrGetProducts', Auth::user());
        return ProductResource::collection(Product::paginate(25));
    }

    /**
     * @param Category $category
     * @return AnonymousResourceCollection
     * @throws AuthorizationException
     */
    public function categoryProducts(Category $category): AnonymousResourceCollection
    {
        $this->authorize('createOrUpdateOrDeleteOrGetProducts', Auth::user());
        return ProductResource::collection(Product::where('category_id', $category->id)->paginate(25));
    }

    /**
     * @param ProductRequest $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function store(ProductRequest $request): JsonResponse
    {
        $this->authorize('createOrUpdateOrDeleteOrGetProducts', Auth::user());
        $data = $request->all();
        if ($request->get('changed_images', false)) $data['images'] = $this->saveImages(
            $request,
            ['image1', 'image2', 'image3', 'image4']
        );
        $product = new Product($data);
        $product->save();
        return response()->json(['id' => $product->id], 201);
    }

    /**
     * @param Product $product
     * @return ProductShowResource
     * @throws AuthorizationException
     */
    public function show(Product $product): ProductShowResource
    {
        $this->authorize('createOrUpdateOrDeleteOrGetProducts', Auth::user());
        return new ProductShowResource($product);
    }

    /**
     * @param ProductRequest $request
     * @param Product $product
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function update(ProductRequest $request, Product $product): JsonResponse
    {
        $this->authorize('createOrUpdateOrDeleteOrGetProducts', Auth::user());
        $data = $request->all();
        if ($request->get('changed_images', false)) $data['images'] = $this->saveImages(
            $request,
            ['image1', 'image2', 'image3', 'image4'],
            $product->images,
            $request->get('removed_images', [])
        );
        $product->update($data);
        return response()->json(['id' => $product->id]);
    }

    /**
     * @param Product $product
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function destroy(Product $product): JsonResponse
    {
        $this->authorize('createOrUpdateOrDeleteOrGetProducts', Auth::user());
        $product->delete();
        return response()->json(['id' => $product->id], 204);
    }
}
