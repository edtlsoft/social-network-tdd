<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CommentLikeController extends Controller
{
    /**
     * CommentLikeController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param Comment $comment
     * @return Response
     */
    public function store(Request $request, Comment $comment)
    {
        return $comment->likes()->create([
            'user_id' => $request->user()->id,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param Comment $comment
     * @return Response
     */
    public function destroy(Request $request, Comment $comment)
    {
        return $comment->likes()->where([
            'user_id' => $request->user()->id,
        ])->delete();
    }
}
