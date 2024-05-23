<?php

use Illuminate\Support\Facades\Schema;

test('lists table has the expected columns', function () {
    expect(Schema::hasColumns('lists', [
        'id', 'name', 'board_id', 'user_id', 'position', 'created_at', 'updated_at'
    ]))->toBeTrue();
});
