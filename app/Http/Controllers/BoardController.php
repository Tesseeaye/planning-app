<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBoardRequest;
use App\Http\Resources\BoardResource;
use App\Models\Board;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BoardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return BoardResource::collection(Board::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBoardRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $validated = $request->safe()->only(['name']);

        $board = Board::create([
            'name' => $validated['name'],
            'user_id' => $request->user('sanctum')->id,
        ]);

        return redirect()->route('api.board.show', $board);
    }

    /**
     * Display the specified resource.
     */
    public function show(Board $board)
    {
        return new BoardResource($board);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreBoardRequest $request, Board $board): RedirectResponse
    {
        $validated = $request->validated();

        $validated = $request->safe()->only(['name']);

        $board->slug = null;

        $board->update([
            'name' => $validated['name'],
        ]);

        return redirect()->route('api.board.show', $board);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Board $board)
    {
        $name = $board->name;

        $board->delete($board);

        return response()->json([
            'message' => 'Board \'' . $name . '\' was deleted successfully.'
        ]);
    }
}