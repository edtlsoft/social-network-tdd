<?php

namespace App\Http\Controllers;

use App\Events\CommentCreated;
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
        $request->validate(['body' => 'required']);

        $comment = $status->comments()->create([
            'user_id' => $request->user()->id,
            'body' => $request->body,
        ]);

        $commentResource = CommentResource::make($comment);

        CommentCreated::dispatch($commentResource);

        return $commentResource;
    }
}
