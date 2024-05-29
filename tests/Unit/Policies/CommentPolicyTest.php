<?php

use App\Models\User;
use App\Models\Comment;
use Laravel\Sanctum\Sanctum;
use App\Policies\CommentPolicy;

beforeEach(function () {
    $this->policy = new CommentPolicy();
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
    $comment = Comment::factory()->for($this->user, 'author')->create();

    expect($this->policy->view($this->user, $comment))->toBeTrue();
});

test('can create', function () {
    expect($this->policy->create($this->user))->tobeTrue();
});

test('can update', function () {
    $comment = Comment::factory()->for($this->user, 'author')->create();

    expect($this->policy->update($this->user, $comment))->toBeTrue();
});

test('can delete', function () {
    $comment = Comment::factory()->for($this->user, 'author')->create();

    expect($this->policy->delete($this->user, $comment))->toBeTrue();
});

test('can\'t restore', function () {
    $comment = Comment::factory()->for($this->user, 'author')->create();

    expect($this->policy->restore($this->user, $comment))->toBeFalse();
});

test('can\'t force delete', function () {
    $comment = Comment::factory()->for($this->user, 'author')->create();

    expect($this->policy->forceDelete($this->user, $comment))->toBeFalse();
});