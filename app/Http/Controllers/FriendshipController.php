<?php

namespace App\Http\Controllers;

use App\Models\Friendship;
use App\Models\Status;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FriendshipController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request, User $recipient)
    {
        return Friendship::create([
            'sender_id' => $request->user()->id,
            'recipient_id' => $recipient->id,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param User $recipient
     * @return Response
     */
    public function destroy(Request $request, User $recipient)
    {
        return Friendship::where([
            'sender_id' => $request->user()->id,
            'recipient_id' => $recipient->id,
        ])->delete();
    }
}
