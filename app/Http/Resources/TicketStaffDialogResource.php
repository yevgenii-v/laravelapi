<?php

namespace App\Http\Resources;

use App\Models\Role;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketStaffDialogResource extends JsonResource
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
            'ticket'        => new TicketResource($this->resource),
            'staffList'     => SupportResource::collection($this->staffList),
            'messages'      => TicketMessagesResource::collection($this->messages),
        ];
    }
}
