<?php

use App\Models\User;
use App\Models\Board;
use App\Policies\BoardPolicy;
use Laravel\Sanctum\Sanctum;

beforeEach(function () {
    $this->policy = new BoardPolicy();
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
    $board = Board::factory()->for($this->user, 'author')->create();

    expect($this->policy->view($this->user, $board))->toBeTrue();
});

test('can create', function () {
    expect($this->policy->create($this->user))->tobeTrue();
});

test('can update', function () {
    $board = Board::factory()->for($this->user, 'author')->create();

    expect($this->policy->update($this->user, $board))->toBeTrue();
});

test('can delete', function () {
    $board = Board::factory()->for($this->user, 'author')->create();

    expect($this->policy->delete($this->user, $board))->toBeTrue();
});

test('can\'t restore', function () {
    $board = Board::factory()->for($this->user, 'author')->create();

    expect($this->policy->restore($this->user, $board))->toBeFalse();
});

test('can\'t force delete', function () {
    $board = Board::factory()->for($this->user, 'author')->create();

    expect($this->policy->forceDelete($this->user, $board))->toBeFalse();
});
