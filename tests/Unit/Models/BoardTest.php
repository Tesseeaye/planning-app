<?php

use App\Models\Attachment;
use App\Models\User;
use App\Models\Board;
use App\Models\Card;
use App\Models\Comment;
use App\Models\Lists;
use Illuminate\Support\Facades\Schema;

describe('verify columns', function () {
    test('board table has the expected columns', function () {
        expect(Schema::hasColumns('boards', [
            'id', 'name', 'user_id', 'slug', 'created_at', 'updated_at',
        ]))->toBeTrue();
    });

    beforeEach(function () {
        $this->board = new Board;
    });

    test('verified fillable columns', function () {
        expect($this->board->getFillable())->toBe([
            'name',
            'user_id',
            'slug',
        ]);
    });

    test('verified column used as route key name', function () {
        expect($this->board->getRouteKeyName())->tobe('slug');
    });
});

describe('verify relationships', function () {
    beforeEach(function () {
        $this->board = Board::factory()->create();
    });

    test('belongs to a user', function () {
        expect($this->board->author()->getRelated())->toBeInstanceOf(User::class);
    });

    test('has many lists', function () {
        Lists::factory()->count(3)->create(['board_id' => $this->board->id]);

        expect($this->board->lists)->toHaveCount(3);
        expect($this->board->lists()->getRelated())->toBeInstanceOf(Lists::class);
    });

    test('has many cards through lists', function () {
        $list = Lists::factory()->create(['board_id' => $this->board->id]);
        Card::factory()->count(3)->create(['lists_id' => $list->id]);

        expect($this->board->cards)->toHaveCount(3);
        expect($this->board->cards()->getRelated())->toBeInstanceOf(Card::class);
    });
});
