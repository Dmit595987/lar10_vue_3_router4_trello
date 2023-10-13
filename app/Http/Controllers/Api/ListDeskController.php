<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ListDeskResource;
use App\Models\ListDesk;
use Illuminate\Http\Request;

class ListDeskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $request->validate(['desk_id' => 'required|integer|exists:desks,id']);

        return ListDeskResource::collection(
            ListDesk::orderBy('created_at', 'desc')
                ->where('desk_id', $request->desk_id)
                ->get());

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
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}