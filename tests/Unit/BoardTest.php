<?php

use Illuminate\Support\Facades\Schema;

test('boards table has the expected columns', function () {
    expect(Schema::hasColumns('boards', [
        'id', 'name', 'user_id', 'created_at', 'updated_at'
    ]))->toBeTrue();
});