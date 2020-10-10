<?php

namespace App\Http\Controllers;

use App\Events\StatusCreated;
use App\Http\Requests\StatusStoreRequest;
use App\Http\Resources\StatusResource;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Event;

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
     * @return StatusResource
     */
    public function store(StatusStoreRequest $request)
    {
        $validate = $request->validate(['body' => 'required|min:5']);

        $status = $request->user()->statuses()->create($validate);

        $statusResource = StatusResource::make($status);

        StatusCreated::dispatch($statusResource);

        return $statusResource;
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
