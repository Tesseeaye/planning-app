<?php

use App\Models\User;
use App\Models\Project;
use App\Policies\ProjectPolicy;
use Laravel\Sanctum\Sanctum;

beforeEach(function () {
    $this->policy = new ProjectPolicy();
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
    $project = Project::factory()->for($this->user, 'author')->create();

    expect($this->policy->view($this->user, $project))->toBeTrue();
});

test('can create', function () {
    expect($this->policy->create($this->user))->tobeTrue();
});

test('can update', function () {
    $project = Project::factory()->for($this->user, 'author')->create();

    expect($this->policy->update($this->user, $project))->toBeTrue();
});

test('can delete', function () {
    $project = Project::factory()->for($this->user, 'author')->create();

    expect($this->policy->delete($this->user, $project))->toBeTrue();
});

test('can\'t restore', function () {
    $project = Project::factory()->for($this->user, 'author')->create();

    expect($this->policy->restore($this->user, $project))->toBeFalse();
});

test('can\'t force delete', function () {
    $project = Project::factory()->for($this->user, 'author')->create();

    expect($this->policy->forceDelete($this->user, $project))->toBeFalse();
});