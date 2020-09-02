<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StatusResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'body' => $this->resource->body,
            'user_name' => $this->resource->user->name,
            'user_avatar' => $this->resource->user->avatar(),
            'user_link' => $this->resource->user->link(),
            'ago' => $this->resource->created_at->diffForHumans(),
            'is_liked' => $this->resource->isLiked(),
            'likes_count' => $this->resource->likesCount(),
            'comments' => CommentResource::collection($this->resource->comments),
        ];
    }
}
