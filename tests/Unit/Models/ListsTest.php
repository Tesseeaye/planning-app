<?php

use App\Models\User;
use App\Models\Board;
use App\Models\Card;
use App\Models\Lists;
use Illuminate\Support\Facades\Schema;

describe('verify columns', function () {
    test('lists table has the expected columns', function () {
        expect(Schema::hasColumns('lists', [
            'id', 'name', 'board_id', 'user_id', 'position','created_at', 'updated_at', 'slug',
        ]))->toBeTrue();
    });

    beforeEach(function () {
        $this->list = new Lists;
    });

    test('verified fillable columns', function () {
        expect($this->list->getFillable())->toBe([
            'name',
            'board_id',
            'user_id',
            'position',
            'slug',
        ]);
    });
});

describe('verify relationships', function () {
    beforeEach(function () {
        $this->list = Lists::factory()->create();
    });

    test('belongs to a board', function () {
        expect($this->list->board()->getRelated())->toBeInstanceOf(Board::class);
    });

    test('belongs to a user', function () {
        expect($this->list->author()->getRelated())->toBeInstanceOf(User::class);
    });

    test('has many cards', function () {
        Card::factory()->count(3)->create(['lists_id' => $this->list->id]);

        expect($this->list->cards)->toHaveCount(3);
        expect($this->list->cards()->getRelated())->toBeInstanceOf(Card::class);
    });
});
