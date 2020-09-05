<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'username' => $this->resource->username,
            'avatar'   => $this->resource->avatar(),
            'link'     => $this->resource->link(),
        ];
    }
}
