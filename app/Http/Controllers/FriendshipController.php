<?php

namespace App\Http\Controllers;

use App\Models\Friendship;
use App\Models\Status;
use App\User;
use Illuminate\Http\JsonResponse;
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
     * @param User $recipient
     * @return JsonResponse
     */
    public function store(Request $request, User $recipient)
    {
        $friendship = Friendship::firstOrCreate([
            'sender_id' => $request->user()->id,
            'recipient_id' => $recipient->id,
        ]);

        return response()->json(['friendship_status' => $friendship->fresh()->status]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     */
    public function destroy(Request $request, User $user)
    {
        $deleted = Friendship::where([
            'sender_id' => $request->user()->id,
            'recipient_id' => $user->id,
        ])->orWhere([
            'sender_id' => $user->id,
            'recipient_id' => $request->user()->id,
        ])->delete();

        return response()->json(['friendship_status' => $deleted ? 'deleted' : '']);
    }
}
