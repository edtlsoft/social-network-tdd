<?php

namespace App\Http\Controllers;

use App\Models\Friendship;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FriendshipController extends Controller
{
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
}
