<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreListsRequest;
use App\Models\Board;
use App\Models\Lists;
use Illuminate\Http\Request;
use App\Http\Resources\ListsResource;
use Illuminate\Http\RedirectResponse;

class ListsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ListsResource::collection(Lists::where('user_id', auth('sanctum')->user()->getAuthIdentifier())->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreListsRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated = $request->safe()->only(['name', 'board_slug']);

        $board = Board::findBySlugOrFail($validated['board_slug']);

        $list = Lists::create([
            'name' => $validated['name'],
            'board_id' => $board->id,
            'user_id' => auth('sanctum')->user()->getAuthIdentifier(),
            'position' => ($board->lists->count() + 1),
        ]);

        return redirect()->route('lists.show', $list);
    }

    /**
     * Display the specified resource.
     */
    public function show(Lists $list)
    {
        return new ListsResource($list);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreListsRequest $request, Lists $list): RedirectResponse
    {
        $validated = $request->validated();

        $validated = $request->safe()->only(['name']);

        $list->update([
            'name' => $validated['name'],
        ]);

        return redirect()->route('lists.show', $list);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lists $list)
    {
        $name = $list->name;

        $list->delete($list);

        return response()->json([
            'message' => 'List \'' . $name . '\' was deleted successfully.'
        ]);
    }
}
