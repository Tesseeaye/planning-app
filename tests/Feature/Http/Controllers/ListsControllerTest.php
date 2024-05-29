<?php

use App\Models\User;
use App\Models\Board;
use App\Models\Lists;
use Laravel\Sanctum\Sanctum;
use App\Http\Resources\ListsResource;

beforeEach(function () {
    Sanctum::actingAs(
        User::factory()->create(), [
            'view',
            'create',
            'update',
            'delete',
        ]);
});

test('"Lists" list can be retrieved', function () {
    Lists::factory(3)->for(auth('sanctum')->user(), 'author')->create();

    $response = $this->get(route('lists.index'));

    $response
        ->assertOk()
        ->assertJson([
            'data' => ListsResource::collection(Lists::where('user_id', auth('sanctum')->user()->getAuthIdentifier())->get())->resolve()
        ]);

    $responseData = $response->json('data');
    $this->assertCount(3, $responseData);
});

test('"Lists" can be stored', function () {
    $board = Board::factory()->for(auth('sanctum')->user(), 'author')->create([
        'name' => 'Test',
    ]);

    $response = $this->post(route('lists.store'), [
        'name' => 'New List',
        'board_slug' => $board->slug,
    ]);

    $this->assertDatabaseHas('lists', [
        'name' => 'New List',
    ]);

    $list = Lists::where('board_id', $board->id)
        ->where('user_id', auth('sanctum')->user()->getAuthIdentifier())
        ->firstOrFail();

    $response
        ->assertStatus(302)
        ->assertRedirectToRoute('lists.show', $list);
});

test('"Lists" can be shown', function () {
    $list = Lists::factory()->create();

    $response = $this->get(route('lists.show', $list));

    $response
        ->assertStatus(200)
        ->assertJson([
            'data' => (new ListsResource($list))->resolve()
        ]);
});

test('"Lists" can be updated', function () {
    $board = Board::factory()->create();

    $list = Lists::factory()->for($board, 'board')->create([
        'name' => 'Original name',
    ]);

    $response = $this->put(route('lists.update', $list), [
        'name' => 'Changed name',
        'board_slug' => $board->slug,
    ]);

    $list->refresh();

    expect($list->name)->toBe('Changed name');

    $response
        ->assertStatus(302)
        ->assertRedirectToRoute('lists.show', $list);
});

test('"Lists" can be destroyed', function () {
    $list = Lists::factory()->create();

    $response = $this->delete(route('lists.destroy', $list));

    $this->assertModelMissing($list);

    $response
        ->assertOk()
        ->assertJson(['message' => 'List \'' . $list->name . '\' was deleted successfully.']);
});