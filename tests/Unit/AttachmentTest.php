<?php

use Illuminate\Support\Facades\Schema;

test('attachments table has the expected columns', function () {
    expect(Schema::hasColumns('attachments', [
        'id', 'file_name', 'file_type', 'file_size', 'card_id', 'user_id', 'created_at', 'updated_at'
    ]))->toBeTrue();
});
