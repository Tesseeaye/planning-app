<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCardRequest;
use App\Http\Resources\CardResource;
use App\Models\Card;
use App\Models\Lists;

class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return CardResource::collection(Card::where('user_id', auth('sanctum')->user()->getAuthIdentifier())->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCardRequest $request)
    {
        $validated = $request->validated();
        $validated = $request->safe()->only(['name', 'content', 'list_slug']);

        $list = Lists::findBySlugOrFail($validated['list_slug']);

        $card = Card::create([
            'name' => $validated['name'],
            'content' => $validated['content'],
            'lists_id' => $list->id,
            'user_id' => auth('sanctum')->user()->getAuthIdentifier(),
            'position' => ($list->cards->count() + 1),
        ]);

        return redirect()->route('card.show', $card);
    }

    /**
     * Display the specified resource.
     */
    public function show(Card $card)
    {
        return new CardResource($card);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCardRequest $request, Card $card)
    {
        $validated = $request->validated();

        $validated = $request->safe()->only(['name', 'content']);

        $card->update([
            'name' => $validated['name'],
            'content' => $validated['content'],
        ]);

        return redirect()->route('card.show', $card);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Card $card)
    {
        $name = $card->name;

        $card->delete($card);

        return response()->json([
            'message' => 'Card \'' . $name . '\' was deleted successfully.'
        ]);
    }
}
