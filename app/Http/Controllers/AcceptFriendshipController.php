<?php

namespace App\Http\Controllers;

use App\Models\Friendship;
use App\User;
use Illuminate\Http\Request;

class AcceptFriendshipController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $sender)
    {
        return Friendship::where([
            'sender_id'    => $sender->id,
            'recipient_id' => $request->user()->id,
            'status'       => 'pending',
        ])->update([
            'status' => 'accepted',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, User $sender)
    {
        return Friendship::where([
            'sender_id'    => $sender->id,
            'recipient_id' => $request->user()->id,
            'status'       => 'pending',
        ])->update([
            'status' => 'denied',
        ]);
    }
}
