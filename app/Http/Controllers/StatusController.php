<?php

namespace App\Http\Controllers;

use App\Http\Requests\StatusStoreRequest;
use App\Http\Resources\StatusResource;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StatusController extends Controller
{
    /**
     * StatusController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return StatusResource::collection(
            Status::latest()->paginate(10)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StatusStoreRequest $request
     * @return Response
     */
    public function store(StatusStoreRequest $request)
    {
        $status = Status::create([
            'user_id' => $request->user()->id,
            'body' => $request->body
        ]);

        return StatusResource::make($status);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Status  $status
     * @return Response
     */
    public function show(Status $status)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Status  $status
     * @return Response
     */
    public function edit(Status $status)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Status  $status
     * @return Response
     */
    public function update(Request $request, Status $status)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Status  $status
     * @return Response
     */
    public function destroy(Status $status)
    {
        //
    }
}
