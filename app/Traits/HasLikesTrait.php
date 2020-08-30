<?php

namespace App\Traits;

use App\Models\Like;

Trait HasLikesTrait
{
    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function like()
    {
        return $this->likes()->firstOrcreate([
            'user_id' => auth()->user()->id
        ]);
    }

    public function unlike()
    {
        return $this->likes()->where([
            'user_id' => auth()->user()->id
        ])->delete();
    }

    public function isLiked()
    {
        return $this->likes()->where('user_id', auth()->id())->exists();
    }

    public function likesCount()
    {
        return $this->likes()->count();
    }
}
