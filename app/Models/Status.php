<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $fillable = ['user_id', 'body'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function like()
    {
        return $this->likes()->firstOrcreate([
            'user_id' => auth()->user()->id
        ]);
    }

    public function isLiked()
    {
        return $this->likes()->where('user_id', auth()->id())->exists();
    }
}
