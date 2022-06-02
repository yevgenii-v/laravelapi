<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CategoryStoreRequest;
use App\Http\Requests\Api\CategoryUpdateRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return CategoryResource::collection(Category::with('getRecursiveChildren')
            ->paginate(25));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CategoryStoreRequest $request
     * @return Response
     */
    public function store(CategoryStoreRequest $request): Response
    {
        Category::create($request->validated());

        return response(['message' => 'New category has been created.']);
    }

    /**
     * Display the specified resource.
     *
     * @param Category $category
     * @return CategoryResource
     */
    public function show(Category $category): CategoryResource
    {
        return CategoryResource::make($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CategoryUpdateRequest $request
     * @param Category $category
     * @return Response
     */
    public function update(CategoryUpdateRequest $request, Category $category): Response
    {
        $category->fill($request->validated())->save();

        return response(['message' => 'Category has been updated.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @return Response
     */
    public function destroy(Category $category): Response
    {
        $category->delete();

        return response(['message' => 'Category has been deleted.']);
    }
}
