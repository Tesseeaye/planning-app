<?php

use App\Models\Card;
use App\Models\User;
use App\Models\Attachment;
use Illuminate\Support\Facades\Schema;

test('attachments table has the expected columns', function () {
    expect(Schema::hasColumns('attachments', [
        'id', 'file_name', 'file_type', 'file_size', 'card_id', 'user_id', 'created_at', 'updated_at'
    ]))->toBeTrue();
});

describe('verify columns', function () {
    beforeEach(function () {
        $this->attachment = new Attachment;
    });

    test('verified fillable', function () {
        expect($this->attachment->getFillable())->toBe([
            'file_name',
            'file_type',
            'file_size',
        ]);
    });
});

describe('verify relationships', function () {
    beforeEach(function () {
        $this->attachment = Attachment::factory()->create();
    });

    test('belongs to a card', function () {
        expect($this->attachment->card()->getRelated())->toBeInstanceOf(Card::class);
    });

    test('belongs to a user', function () {
        expect($this->attachment->author()->getRelated())->toBeInstanceOf(User::class);
    });
});
