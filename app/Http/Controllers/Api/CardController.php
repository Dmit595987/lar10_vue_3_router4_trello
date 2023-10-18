<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CardStoreRequest;
use App\Http\Requests\Api\CardUpdateRequest;
use App\Http\Requests\Api\DeskStoreRequest;
use App\Http\Requests\Api\DeskUpdateRequest;
use App\Http\Resources\CardResource;
use App\Http\Resources\DeskResource;
use App\Models\Card;
use App\Models\Desk;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Request;


class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return 1111;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CardStoreRequest $request)
    {
        $data = $request->validated();
        $card = Card::create($data);
        return new CardResource($card);
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
