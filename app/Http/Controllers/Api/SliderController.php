<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SliderStoreRequest;
use App\Http\Requests\Api\SliderUpdateRequest;
use App\Http\Resources\SliderResource;
use App\Models\Slider;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return SliderResource::collection(Slider::paginate(25));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SliderStoreRequest $request
     * @return Response
     */
    public function store(SliderStoreRequest $request): Response
    {
        Slider::create($request->validated());

        return response(['message' => 'Slider has been created.'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Slider $slider
     * @return SliderResource
     */
    public function show(Slider $slider): SliderResource
    {
        return SliderResource::make($slider);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SliderUpdateRequest $request
     * @param Slider $slider
     * @return Response
     */
    public function update(SliderUpdateRequest $request, Slider $slider): Response
    {
        $slider->fill($request->validated())->save();

        return response(['message' => 'Slider has been updated.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Slider $slider
     * @return Response
     */
    public function destroy(Slider $slider): Response
    {
        $slider->delete();

        return response(['message' => 'Slider has been deleted.']);
    }
}
