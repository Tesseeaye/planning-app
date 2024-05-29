<?php

use App\Models\Card;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Support\Facades\Schema;

describe('verify columns', function () {
    test('comments table has the expected columns', function () {
        expect(Schema::hasColumns('comments', [
            'id', 'text', 'card_id', 'user_id', 'created_at', 'updated_at'
        ]))->toBeTrue();
    });

    beforeEach(function () {
        $this->comment = new Comment;
    });

    test('verified fillable columns', function () {
        expect($this->comment->getFillable())->toBe(['text']);
    });
});

describe('verify relationships', function () {
    beforeEach(function () {
        $this->comment = Comment::factory()->create();
    });

    test('belongs to a card', function () {
        expect($this->comment->card()->getRelated())->toBeInstanceOf(Card::class);
    });

    test('belongs to a user', function () {
        expect($this->comment->author()->getRelated())->toBeInstanceOf(User::class);
    });
});

test('can create a new comment', function () {
    $comment = Comment::factory()->create(['text' => 'Lorem Ipsum']);

    expect($comment->text)->toBe('Lorem Ipsum');
});