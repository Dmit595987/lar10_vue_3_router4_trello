<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
        $desks = Desk::all();
        return DeskResource::collection($desks);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function destroy(string $id)
    {
        //
    }
}
