<?php

use App\Models\Card;
use App\Models\User;
use App\Models\Lists;
use Laravel\Sanctum\Sanctum;
use App\Http\Resources\CardResource;

beforeEach(function () {
    Sanctum::actingAs(
        User::factory()->create(), [
            'view',
            'create',
            'update',
            'delete',
        ]);
});

test('"Card" list can be retrieved', function () {
    Card::factory(3)->for(auth('sanctum')->user(), 'author')->create();

    $response = $this->get(route('card.index'));

    $response
        ->assertOk()
        ->assertJson([
            'data' => CardResource::collection(Card::where('user_id', auth('sanctum')->user()->getAuthIdentifier())->get())->resolve()
        ]);

    $responseData = $response->json('data');
    $this->assertCount(3, $responseData);
});

test('"Card" can be stored', function () {
    $list = Lists::factory()->for(auth('sanctum')->user(), 'author')->create([
        'name' => 'Test',
    ]);

    $response = $this->post(route('card.store'), [
        'name' => 'New Card',
        'content' => 'Lorem Ipsum',
        'list_slug' => $list->slug,
    ]);

    $this->assertDatabaseHas('cards', [
        'name' => 'New Card',
        'content' => 'Lorem Ipsum',
    ]);

    $card = Card::where('lists_id', $list->id)
        ->where('user_id', auth('sanctum')->user()->getAuthIdentifier())
        ->firstOrFail();

    $response
        ->assertStatus(302)
        ->assertRedirectToRoute('card.show', $card);
});

test('"Card" can be shown', function () {
    $card = Card::factory()->create();

    $response = $this->get(route('card.show', $card));

    $response
        ->assertStatus(200)
        ->assertJson([
            'data' => (new CardResource($card))->resolve()
        ]);
});

test('"Card" can be updated', function () {
    $list = Lists::factory()->create();
    $card = Card::factory()->for($list, 'list')->create([
        'name' => 'Original name',
    ]);

    $response = $this->put(route('card.update', $card), [
        'name' => 'Changed name',
        'content' => 'New content',
        'list_slug' => $list->slug,
    ]);

    $card->refresh();

    expect($card->name)->toBe('Changed name');
    expect($card->content)->toBe('New content');

    $response
        ->assertStatus(302)
        ->assertRedirectToRoute('card.show', $card);
});

test('"Card" can be destroyed', function () {
    $card = Card::factory()->create();

    $response = $this->delete(route('card.destroy', $card));

    $this->assertModelMissing($card);

    $response
        ->assertOk()
        ->assertJson(['message' => 'Card \'' . $card->name . '\' was deleted successfully.']);});