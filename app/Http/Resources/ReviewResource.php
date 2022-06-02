<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'title'         => $this->title,
            'description'   => $this->description,
            'rating'        => $this->rating,
            'product'       => ProductResource::make($this->product),
        ];
    }
}
