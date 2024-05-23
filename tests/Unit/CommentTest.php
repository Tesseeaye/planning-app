<?php

use Illuminate\Support\Facades\Schema;

test('comments table has the expected columns', function () {
    expect(Schema::hasColumns('comments', [
        'id', 'text', 'card_id', 'user_id', 'created_at', 'updated_at'
    ]))->toBeTrue();
});