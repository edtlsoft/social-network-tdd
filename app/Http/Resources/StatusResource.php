<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StatusResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'body' => $this->resource->body,
            'user_name' => $this->resource->user->name,
            'user_avatar' => '/images/default-avatar.jpg',
            'ago' => $this->resource->created_at->diffForHumans(),
            'is_liked' => $this->resource->isLiked()
        ];
    }
}
