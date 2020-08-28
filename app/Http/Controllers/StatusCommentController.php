<?php

namespace App\Http\Controllers;

use App\Http\Requests\StatusCommentStoreRequest;
use App\Http\Resources\CommentResource;
use App\Models\Status;
use Illuminate\Http\Request;

class StatusCommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(StatusCommentStoreRequest $request, Status $status)
    {
        $comment = $status->comments()->create([
            'user_id' => $request->user()->id,
            'body' => $request->body,
        ]);

        return CommentResource::make($comment);
    }
}
