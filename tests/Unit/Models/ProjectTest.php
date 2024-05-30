<?php

use App\Models\User;
use App\Models\Project;
use App\Models\Card;
use App\Models\Lists;
use Illuminate\Support\Facades\Schema;

describe('verify columns', function () {
    test('project table has the expected columns', function () {
        expect(Schema::hasColumns('projects', [
            'id', 'name', 'user_id', 'slug', 'created_at', 'updated_at',
        ]))->toBeTrue();
    });

    beforeEach(function () {
        $this->project = new Project;
    });

    test('verified fillable columns', function () {
        expect($this->project->getFillable())->toBe([
            'name',
            'user_id',
            'slug',
        ]);
    });

    test('verified column used as route key name', function () {
        expect($this->project->getRouteKeyName())->tobe('slug');
    });
});

describe('verify relationships', function () {
    beforeEach(function () {
        $this->project = Project::factory()->create();
    });

    test('belongs to a user', function () {
        expect($this->project->author()->getRelated())->toBeInstanceOf(User::class);
    });

    test('has many lists', function () {
        Lists::factory()->count(3)->create(['project_id' => $this->project->id]);

        expect($this->project->lists)->toHaveCount(3);
        expect($this->project->lists()->getRelated())->toBeInstanceOf(Lists::class);
    });

    test('has many cards through lists', function () {
        $list = Lists::factory()->create(['project_id' => $this->project->id]);
        Card::factory()->count(3)->create(['lists_id' => $list->id]);

        expect($this->project->cards)->toHaveCount(3);
        expect($this->project->cards()->getRelated())->toBeInstanceOf(Card::class);
    });
});