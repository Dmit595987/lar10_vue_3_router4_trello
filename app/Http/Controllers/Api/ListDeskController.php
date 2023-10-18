<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ListDeskStoreRequest;
use App\Http\Requests\Api\ListDeskUpdateRequest;
use App\Http\Resources\ListDeskResource;
use App\Models\ListDesk;

use Illuminate\Http\Request;
use Illuminate\Http\Response;


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
    public function store(ListDeskStoreRequest $request)
    {
        $data = $request->validated();
        $list_desk = ListDesk::create($data);
        return new ListDeskResource($list_desk);
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
    public function update(ListDeskUpdateRequest $request, ListDesk $list_Desk)
    {
        $data = $request->validated();
        $list_Desk->update($data);
        return new ListDeskResource($list_Desk);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(ListDesk $list_Desk)
    {
        $list_Desk->delete();
        return response([], 200);
    }
}
