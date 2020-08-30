<?php

namespace App\Models;

use App\Traits\HasLikesTrait;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasLikesTrait;

    protected $fillable = ['user_id', 'body'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
