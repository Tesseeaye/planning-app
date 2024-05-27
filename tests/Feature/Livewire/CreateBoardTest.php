<?php

use App\Livewire\CreateBoard;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(CreateBoard::class)
        ->assertStatus(200);
});
