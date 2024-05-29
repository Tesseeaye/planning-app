<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Http\Resources\CommentResource;
use App\Http\Requests\StoreCommentRequest;
use App\Models\Card;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return CommentResource::collection(Comment::where('user_id', auth('sanctum')->user()->getAuthIdentifier())->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommentRequest $request)
    {
        $validated = $request->validated();
        $validated = $request->safe()->only(['content', 'card_slug']);

        $card = Card::findBySlugOrFail($validated['card_slug']);

        $comment = Comment::create([
            'content' => $validated['content'],
            'card_id' => $card->id,
            'user_id' => auth('sanctum')->user()->getAuthIdentifier(),
        ]);

        return redirect()->route('comment.show', $comment);
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        return new CommentResource($comment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCommentRequest $request, Comment $comment)
    {
        $validated = $request->validated();

        $validated = $request->safe()->only(['content']);

        $comment->update([
            'content' => $validated['content'],
        ]);

        return redirect()->route('comment.show', $comment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $name = $comment->author->name;

        $comment->delete($comment);

        return response()->json([
            'message' => 'Comment by user \'' . $name . '\' was deleted successfully.'
        ]);
    }
}
