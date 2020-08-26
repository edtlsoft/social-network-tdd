<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            'body' => $this->resource->body,
            'user_name' => $this->resource->user->name,
            'user_avatar' => '/images/default-avatar.jpg'
        ];
    }
}
