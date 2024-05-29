<?php

use App\Models\User;
use App\Models\Lists;
use Laravel\Sanctum\Sanctum;
use App\Policies\ListsPolicy;

beforeEach(function () {
    $this->policy = new ListsPolicy();
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
    $list = Lists::factory()->for($this->user, 'author')->create();

    expect($this->policy->view($this->user, $list))->toBeTrue();
});

test('can create', function () {
    expect($this->policy->create($this->user))->tobeTrue();
});

test('can update', function () {
    $list = Lists::factory()->for($this->user, 'author')->create();

    expect($this->policy->update($this->user, $list))->toBeTrue();
});

test('can delete', function () {
    $list = Lists::factory()->for($this->user, 'author')->create();

    expect($this->policy->delete($this->user, $list))->toBeTrue();
});

test('can\'t restore', function () {
    $list = Lists::factory()->for($this->user, 'author')->create();

    expect($this->policy->restore($this->user, $list))->toBeFalse();
});

test('can\'t force delete', function () {
    $list = Lists::factory()->for($this->user, 'author')->create();

    expect($this->policy->forceDelete($this->user, $list))->toBeFalse();
});