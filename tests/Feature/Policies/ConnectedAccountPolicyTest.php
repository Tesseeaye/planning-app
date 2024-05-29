<?php

use App\Models\ConnectedAccount;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use App\Policies\ConnectedAccountPolicy;

beforeEach(function () {
    $this->policy = new ConnectedAccountPolicy;
    $this->user = User::factory()->create();

    Sanctum::actingAs($this->user, [
        'create',
        'read',
        'update',
        'delete'
    ]);
});

test('can viewAny', function () {
    expect($this->policy->viewAny($this->user))->toBeTrue();
});

test('can view', function () {
    $connectedAccount = ConnectedAccount::factory()->for($this->user)->create();

    expect($this->policy->view($this->user, $connectedAccount))->toBeTrue();
});

test('can create', function () {
    expect($this->policy->create($this->user))->toBeTrue();
});

test('can update', function () {
    $connectedAccount = ConnectedAccount::factory()->for($this->user)->create();

    expect($this->policy->update($this->user, $connectedAccount))->toBeTrue();
});

test('can delete', function () {
    $connectedAccount = ConnectedAccount::factory()->for($this->user)->create();

    expect($this->policy->delete($this->user, $connectedAccount))->toBeTrue();
});