<?php

use App\Models\Comment;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use App\Http\Resources\CommentResource;
use App\Models\Card;

beforeEach(function () {
    Sanctum::actingAs(
        User::factory()->create(), [
            'view',
            'create',
            'update',
            'delete',
        ]);
});

test('"Comment" card can be retrieved', function () {
    Comment::factory(3)->for(auth('sanctum')->user(), 'author')->create();

    $response = $this->get(route('comment.index'));

    $response
        ->assertOk()
        ->assertJson([
            'data' => CommentResource::collection(Comment::where('user_id', auth('sanctum')->user()->getAuthIdentifier())->get())->resolve()
        ]);

    $responseData = $response->json('data');
    $this->assertCount(3, $responseData);
});

test('"Comment" can be stored', function () {
    $card = Card::factory()->for(auth('sanctum')->user(), 'author')->create();

    $response = $this->post(route('comment.store'), [
        'content' => 'New Comment',
        'card_slug' => $card->slug,
    ]);

    $this->assertDatabaseHas('comments', [
        'content' => 'New Comment',
    ]);

    $comment = Comment::where('card_id', $card->id)
        ->where('user_id', auth('sanctum')->user()->getAuthIdentifier())
        ->firstOrFail();

    $response
        ->assertStatus(302)
        ->assertRedirectToRoute('comment.show', $comment);
});

test('"Comment" can be shown', function () {
    $comment = Comment::factory()->create();

    $response = $this->get(route('comment.show', $comment));

    $response
        ->assertStatus(200)
        ->assertJson([
            'data' => (new CommentResource($comment))->resolve()
        ]);
});

test('"Comment" can be updated', function () {
    $card = Card::factory()->create();
    $comment = Comment::factory()->for($card, 'card')->create([
        'content' => 'Original name',
    ]);

    $response = $this->put(route('comment.update', $comment), [
        'content' => 'Changed name',
        'card_slug' => $card->slug,
    ]);

    $comment->refresh();

    expect($comment->content)->toBe('Changed name');

    $response
        ->assertStatus(302)
        ->assertRedirectToRoute('comment.show', $comment);
});

test('"Comment" can be destroyed', function () {
    $comment = Comment::factory()->create();

    $response = $this->delete(route('comment.destroy', $comment));

    $this->assertModelMissing($comment);

    $response
        ->assertOk()
        ->assertJson(['message' => 'Comment by user \'' . $comment->author->name . '\' was deleted successfully.']);});