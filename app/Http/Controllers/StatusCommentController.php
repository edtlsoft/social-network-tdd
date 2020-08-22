<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;

class StatusCommentController extends Controller
{
    public function store(Request $request, Status $status)
    {
        $status->comments()->create([
            'user_id' => $request->user()->id,
            'body' => $request->body,
        ]);


    }
}
