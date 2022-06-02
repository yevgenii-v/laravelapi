<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ReviewStoreRequest;
use App\Http\Requests\Api\ReviewUpdateRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return ReviewResource::collection(Review::paginate(25));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ReviewStoreRequest $request
     * @param Product $product
     * @return Response
     */
    public function store(ReviewStoreRequest $request, Product $product): Response
    {
        if ($product->reviews()->where('user_id', auth('sanctum')->user()->id)->count() > 0)
        {
            return response(['message' => 'You already wrote review.']);
        }

        $data = $request->validated();

        Review::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'rating' => $data['rating'],
            'product_id' => $product->id,
        ]);

        return response(['message' => 'Review has been posted.']);
    }

    /**
     * Display the specified resource.
     *
     * @param Product $product
     * @param Review $review
     * @return ReviewResource|Application|ResponseFactory|Response
     */
    public function show(Product $product, Review $review)
    {
        if($review->product_id !== $product->id)
        {
            return response(['message' => 'Not found'], 404);
        }

        return ReviewResource::make($review);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ReviewUpdateRequest $request
     * @param Product $product
     * @param Review $review
     * @return Response
     */
    public function update(ReviewUpdateRequest $request, Product $product, Review $review): Response
    {
        if($review->product_id !== $product->id)
        {
            return response(['message' => 'Not found'], 404);
        }

        $review->fill($request->validated())->save();

        return response(['message' => 'Review has been updated.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @param Review $review
     * @return Response
     */
    public function destroy(Product $product, Review $review): Response
    {
        if($product->id !== $review->product_id)
        {
            return response(['message' => 'Not found'], 404);
        }

        $review->delete();

        return response(['message' => 'Review has been deleted.']);
    }

}
