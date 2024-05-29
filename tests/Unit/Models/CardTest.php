<?php

use App\Models\Attachment;
use App\Models\Board;
use App\Models\Card;
use App\Models\Comment;
use App\Models\Lists;
use App\Models\User;
use Illuminate\Support\Facades\Schema;

describe('verify columns', function () {
    test('cards table has the expected columns', function () {
        expect(Schema::hasColumns('cards', [
            'id', 'name', 'content', 'lists_id', 'user_id', 'position', 'created_at', 'updated_at', 'slug'
        ]))->toBeTrue();
    });

    beforeEach(function () {
        $this->card = new Card;
    });

    test('verified fillable columns', function () {
        expect($this->card->getFillable())->toBe([
            'name',
            'content',
            'lists_id',
            'user_id',
            'slug',
            'position',
        ]);
    });
});

describe('verify relationships', function () {
    beforeEach(function () {
        $this->card = Card::factory()->create();
    });

    test('belongs to a user', function () {
        expect($this->card->author()->getRelated())->toBeInstanceOf(User::class);
    });

    test('belongs to a list', function () {
        expect($this->card->list()->getRelated())->toBeInstanceOf(Lists::class);
    });

    test('belongs to a board', function () {
        expect($this->card->board()->getRelated())->toBeInstanceOf(Board::class);
    });

    test('has many attachments', function () {
        Attachment::factory()->count(3)->create(['card_id' => $this->card->id]);

        expect($this->card->attachments)->toHaveCount(3);
        expect($this->card->attachments()->getRelated())->toBeInstanceOf(Attachment::class);
    });

    test('has many comments', function () {
        Comment::factory()->count(3)->create(['card_id' => $this->card->id]);

        expect($this->card->comments)->toHaveCount(3);
        expect($this->card->comments()->getRelated())->toBeInstanceOf(Comment::class);
    });
});
