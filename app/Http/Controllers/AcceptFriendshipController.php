<?php

namespace App\Http\Controllers;

use App\Models\Friendship;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AcceptFriendshipController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $friendshipRequests = Friendship::where('recipient_id', auth()->id())->with('sender')->get();

        return view('friendships.index', compact('friendshipRequests'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param User $sender
     * @return JsonResponse
     */
    public function store(Request $request, User $sender)
    {
        Friendship::where([
            'sender_id'    => $sender->id,
            'recipient_id' => $request->user()->id,
            'status'       => 'pending',
        ])->update([
            'status' => 'accepted',
        ]);

        return response()->json(['friendship_status' => 'accepted']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param User $sender
     * @return JsonResponse
     */
    public function destroy(Request $request, User $sender)
    {
        Friendship::where([
            'sender_id'    => $sender->id,
            'recipient_id' => $request->user()->id,
            'status'       => 'pending',
        ])->update([
            'status' => 'denied',
        ]);

        return response()->json(['friendship_status' => 'denied']);
    }
}
