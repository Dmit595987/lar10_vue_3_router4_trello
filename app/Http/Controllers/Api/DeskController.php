<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\DeskStoreRequest;
use App\Http\Requests\Api\DeskUpdateRequest;
use App\Http\Resources\DeskResource;
use App\Models\Desk;
use Illuminate\Http\Request;

class DeskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $desks = Desk::orderBy('created_at', 'desc')->get();
        return DeskResource::collection($desks);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DeskStoreRequest $request)
    {
        $data = $request->validated();
        Desk::create($data);
        return response([], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Desk $desk)
    {

        return New DeskResource($desk);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DeskUpdateRequest $request, Desk $desk)
    {
        $data = $request->validated();
        $desk->update($data);
        return response([], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Desk $desk)
    {
        $desk->delete();
        return response([], 200);
    }
}
