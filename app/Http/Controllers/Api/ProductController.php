<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ProductStoreRequest;
use App\Http\Requests\Api\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->topLatest = Product::orderBy('id', 'desc')->take(10)->get();
    }

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return ProductResource::collection(Product::withAvg('reviews', 'rating')
            ->orderBy('reviews_avg_rating', 'desc')->paginate(25))
            ->additional([
                'top_latest'    => $this->topLatest,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductStoreRequest $request
     * @param Category $category
     * @return Response
     */
    public function store(ProductStoreRequest $request, Category $category): Response
    {
        $validatedData = $request->validated();

        $newProduct = Product::create([
            'name'        => $validatedData['name'],
            'description' => $validatedData['description'],
            'category_id' => $category->id,
        ]);

        $newProduct->related()->sync($validatedData['related_id']);

        return response(['message' => 'Product has been posted.']);
    }

    /**
     * Display the specified resource.
     *
     * @param Category $category
     * @param Product $product
     * @return ProductResource|Application|ResponseFactory|Response
     */
    public function show(Category $category, Product $product)
    {
        if ($product->category_id !== $category->id)
        {
            return response(['message' => 'Not found'], 404);
        }

        return ProductResource::make($product)
            ->additional([
                'top_latest'        => $this->topLatest,
                'related_products'  => ProductResource::collection($product->related),
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductUpdateRequest $request
     * @param Category $category
     * @param Product $product
     * @return Response
     */
    public function update(ProductUpdateRequest $request, Category $category, Product $product): Response
    {
        $validatedData = $request->validated();

        if ($product->category_id !== $category->id)
        {
            return response(['message' => 'Not found'], 404);
        }

        $product->fill([
            'name'        => $validatedData['name'],
            'description' => $validatedData['description'],
            'category_id' => $validatedData['category_id'],
        ])->save();

        $product->related()->sync($validatedData['related_id']);

        return response(['message' => 'Product has been updated.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @param Product $product
     * @return Response
     */
    public function destroy(Category $category, Product $product): Response
    {
        if ($product->category_id !== $category->id)
        {
            return response(['message' => 'Not found'], 404);
        }

        $product->delete();

        return response(['message' => 'Product has been deleted.']);
    }
}
