<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\TaskStoreRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Response;



class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return 1111;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskStoreRequest $request)
    {
        $data = $request->validated();
        $task = Task::create($data);
        return new TaskResource($task);
    }

    /**
     * Display the specified resource.
     */
    public function show(Card $card)
    {
        return New CardResource($card);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CardUpdateRequest $request, Card $card)
    {
        $data = $request->validated();
        $card->update($data);
        return new CardResource($card);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Card $card)
    {
        $card->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
