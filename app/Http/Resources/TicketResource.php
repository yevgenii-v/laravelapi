<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
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
            'id'            => $this->id,
            'title'         => $this->title,
            'message'       => $this->message,
            'user'     => [
                'id'        => $this->user->id,
                'name'      => $this->user->name,
                'email'     => $this->user->email,
            ],
            'status'        => [
                'id'        => $this->status->id,
                'name'      => $this->status->name,
            ],
            'support'       => $this->support->name ?? '',
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at,
        ];
    }
}
