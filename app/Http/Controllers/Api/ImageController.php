<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ImageStoreRequest;
use App\Http\Requests\Api\ImageUpdateRequest;
use App\Http\Resources\ImageResource;
use App\Models\Image;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return ImageResource::collection(Image::paginate(25));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Slider $slider
     * @param ImageStoreRequest $request
     * @return Response
     */
    public function store(ImageStoreRequest $request, Slider $slider): Response
    {
        $file = $request->file('path');

        $validatedData = $request->validated();

        if($request->hasFile('path')) {
            $validatedData['path'] = $file->store($slider->id, 'sliders');

            Image::create([
                'name'      => $validatedData['name'],
                'path'      => $validatedData['path'],
                'slider_id' => $slider->id,
            ]);

            return response(['message' => 'Image has been added.']);
        }

        return response(['message' => 'Oops, something gonna wrong.']);
    }

    /**
     * Display the specified resource.
     *
     * @param Slider $slider
     * @param Image $image
     * @return ImageResource
     */
    public function show(Slider $slider, Image $image): ImageResource
    {
        return ImageResource::make($image);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ImageUpdateRequest $request
     * @param Slider $slider
     * @param Image $image
     * @return Response
     */
    public function update(ImageUpdateRequest $request, Slider $slider, Image $image): Response
    {
        $file = $request->file('path');
        $oldFile = 'storage/sliders/'.$image->path;

        $validatedData = $request->validated();

        if($request->hasFile('path')) {
            if(File::exists($oldFile)) {
                File::delete($oldFile);
                $image->delete();
            }

            $validatedData['path'] = $file->store($slider->id, 'sliders');

            $image->fill($validatedData)->save();

            return response(['message' => 'Image has been updated.']);
        }

        return response(['message' => 'Oops, something gonna wrong.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Slider $slider
     * @param Image $image
     * @return Response
     */
    public function destroy(Slider $slider, Image $image): Response
    {
        $path = 'storage/sliders/'.$image->path;

        if(File::exists($path)) {
            File::delete($path);
            $image->delete();

            return response(['message' => 'Image has been deleted.']);
        }

        return response(['message' => 'Image do not exists.']);
    }
}
