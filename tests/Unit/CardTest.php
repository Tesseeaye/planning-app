<?php

use Illuminate\Support\Facades\Schema;

test('cards table has the expected columns', function () {
    expect(Schema::hasColumns('cards', [
        'id', 'title', 'content', 'lists_id', 'user_id', 'position', 'created_at', 'updated_at'
    ]))->toBeTrue();
});
