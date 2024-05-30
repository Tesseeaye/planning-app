<?php

use App\Models\User;
use App\Models\Attachment;
use Laravel\Sanctum\Sanctum;
use App\Policies\AttachmentPolicy;

beforeEach(function () {
    $this->policy = new AttachmentPolicy();
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
    $attachment = Attachment::factory()->for($this->user, 'author')->create();

    expect($this->policy->view($this->user, $attachment))->toBeTrue();
});

test('can create', function () {
    expect($this->policy->create($this->user))->tobeTrue();
});

test('can update', function () {
    $attachment = Attachment::factory()->for($this->user, 'author')->create();

    expect($this->policy->update($this->user, $attachment))->toBeTrue();
});

test('can delete', function () {
    $attachment = Attachment::factory()->for($this->user, 'author')->create();

    expect($this->policy->delete($this->user, $attachment))->toBeTrue();
});

test('can\'t restore', function () {
    $attachment = Attachment::factory()->for($this->user, 'author')->create();

    expect($this->policy->restore($this->user, $attachment))->toBeFalse();
});

test('can\'t force delete', function () {
    $attachment = Attachment::factory()->for($this->user, 'author')->create();

    expect($this->policy->forceDelete($this->user, $attachment))->toBeFalse();
});