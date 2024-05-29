<?php

use App\Models\User;
use App\Models\Card;
use Laravel\Sanctum\Sanctum;
use App\Policies\CardPolicy;

beforeEach(function () {
    $this->policy = new CardPolicy();
    $this->user = User::factory()->create();

    Sanctum::actingAs($this->user, [
        'create',
        'read',
        'update',
        'delete'
    ]);
});

test('can\'t viewAny', function () {
    expect($this->policy->viewAny($this->user))->toBeFalse();
});

test('can view', function () {
    $card = Card::factory()->for($this->user, 'author')->create();

    expect($this->policy->view($this->user, $card))->toBeTrue();
});

test('can create', function () {
    expect($this->policy->create($this->user))->tobeTrue();
});

test('can update', function () {
    $card = Card::factory()->for($this->user, 'author')->create();

    expect($this->policy->update($this->user, $card))->toBeTrue();
});

test('can delete', function () {
    $card = Card::factory()->for($this->user, 'author')->create();

    expect($this->policy->delete($this->user, $card))->toBeTrue();
});

test('can\'t restore', function () {
    $card = Card::factory()->for($this->user, 'author')->create();

    expect($this->policy->restore($this->user, $card))->toBeFalse();
});

test('can\'t force delete', function () {
    $card = Card::factory()->for($this->user, 'author')->create();

    expect($this->policy->forceDelete($this->user, $card))->toBeFalse();
});
