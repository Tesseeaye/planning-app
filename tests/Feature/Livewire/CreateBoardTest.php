<?php

use App\Models\User;
use Livewire\Livewire;

use App\Livewire\CreateBoard;
use function Pest\Laravel\actingAs;

it('renders successfully', function () {
    Livewire::test(CreateBoard::class)
        ->assertStatus(200);
});

it('can create board', function () {
    actingAs(User::factory()->create());

    Livewire::test(CreateBoard::class)
        ->set('name', 'Test Board')
        ->call('createBoard');

    $this->assertDatabaseHas('boards', [
        'name' => 'Test Board',
    ]);
});
