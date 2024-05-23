<?php

use App\Models\Attachment;
use App\Models\User;
use App\Models\Card;
use App\Models\Lists;
use App\Models\Board;
use App\Models\Comment;
use Illuminate\Support\Facades\Schema;

describe('verify columns', function() {
    test('users table has the expected columns', function () {
        expect(Schema::hasColumns('users', [
            'id', 'name', 'email', 'email_verified_at', 'password', 'two_factor_secret', 'two_factor_recovery_codes', 'remember_token', 'profile_photo_path', 'current_team_id',
        ]))->toBeTrue();
    });

    beforeEach(function () {
        $this->user = new User;
    });

    test('verified fillable columns', function () {
        expect($this->user->getFillable())->toBe([
            'name',
            'email',
            'password',
        ]);
    });

    test('verified hidden columns', function () {
        expect($this->user->getHidden())->toBe([
            'password',
            'remember_token',
            'two_factor_recovery_codes',
            'two_factor_secret',
        ]);
    });

    test('verified append columns', function () {
        expect($this->user->getAppends())->toBe([
            'profile_photo_url',
        ]);
    });

    test('verified column casting', function () {
        expect($this->user->getCasts())->toMatchArray([
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ]);
    });
});

describe('verify relationships', function () {
    beforeEach(function () {
        $this->user = User::factory()->create();
    });

    test('has many boards', function () {
        Board::factory()->count(3)->create(['user_id' => $this->user->id]);

        expect($this->user->boards)->toHaveCount(3);
        expect($this->user->boards()->getRelated())->toBeInstanceOf(Board::class);
    });

    test('has many lists through boards', function () {
        $board = Board::factory()->create(['user_id' => $this->user->id]);
        Lists::factory()->count(3)->create(['board_id' => $board->id]);

        expect($this->user->lists)->toHaveCount(3);
        expect($this->user->lists()->getRelated())->toBeInstanceOf(Lists::class);
    });

    test('has many cards through lists', function () {
        $board = Board::factory()->create(['user_id' => $this->user->id]);
        $list = Lists::factory()->create(['board_id' => $board->id]);
        Card::factory()->count(3)->create(['lists_id' => $list->id]);

        expect($this->user->cards)->toHaveCount(3);
        expect($this->user->cards()->getRelated())->toBeInstanceOf(Card::class);
    });

    test('has many comments through cards', function () {
        $board = Board::factory()->create(['user_id' => $this->user->id]);
        $list = Lists::factory()->create(['board_id' => $board->id]);
        $card = Card::factory()->create(['lists_id' => $list->id]);
        Comment::factory()->count(3)->create(['card_id' => $card->id]);

        expect($this->user->comments)->toHaveCount(3);
        expect($this->user->comments()->getRelated())->toBeInstanceOf(Comment::class);
    });

    test('has many attachments through cards', function () {
        $board = Board::factory()->create(['user_id' => $this->user->id]);
        $list = Lists::factory()->create(['board_id' => $board->id]);
        $card = Card::factory()->create(['lists_id' => $list->id]);
        Attachment::factory()->count(3)->create(['card_id' => $card->id]);

        expect($this->user->attachments)->toHaveCount(3);
        expect($this->user->attachments()->getRelated())->toBeInstanceOf(Attachment::class);
    });
});

test('can create a new user', function () {
    $user = User::factory()->create([
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => bcrypt('password'),
    ]);

    expect($user->name)->toBe('John Doe');
    expect($user->email)->toBe('john@example.com');
    expect(password_verify('password', $user->password))->toBeTrue();
});
