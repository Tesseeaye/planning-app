<?php

use App\Models\User;
use App\Models\Board;
use function Pest\Laravel\actingAs;

use App\Http\Resources\BoardResource;

beforeEach(function () {
    actingAs(User::factory()->create());
});

test('can index', function () {
    Board::factory()->count(3)->for(auth('sanctum')->user(), 'author')->create();

    $response = $this->getJson(route('board.index'));

    $response->assertStatus(200)
        ->assertJson([
            'data' => BoardResource::collection(Board::where('user_id', auth('sanctum')->user()->getAuthIdentifier())->get())->resolve()
        ]);

    $responseData = $response->json('data');
    $this->assertCount(3, $responseData);
});

test('can store', function () {
    $response = $this->postJson(route('board.store'), [
        'name' => 'Lorem Ipsum',
    ]);

    $this->assertDatabaseHas('boards', [
        'name' => 'Lorem Ipsum',
    ]);

    $response
        ->assertStatus(302)
        ->assertRedirectToRoute('board.show', Board::where('name', 'Lorem Ipsum')->firstOrFail());
});

test('can show', function () {
    $board = Board::factory()->create();

    $response = $this->getJson(route('board.show', $board));

    $response
        ->assertStatus(200)
        ->assertJson([
            'data' => (new BoardResource($board))->resolve()
        ]);
});

test('can update', function () {
    $board = Board::factory()->create();

    $response = $this->putJson(route('board.update', $board), [
        'name' => 'Changed name',
    ]);

    $response
        ->assertStatus(302)
        ->assertRedirectToRoute('board.show', Board::where('name', 'Changed name')->firstOrFail());
});

test('can destroy', function () {
    $board = Board::factory()->create();

    $response = $this->deleteJson(route('board.destroy', $board));

    $this->assertModelMissing($board);

    $response
        ->assertStatus(200)
        ->assertJson(['message' => 'Board \'' . $board->name . '\' was deleted successfully.']);
});
