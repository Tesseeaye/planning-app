<?php

namespace App\Livewire;

use App\Models\Board;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;

class CreateBoard extends Component
{
    #[Validate('required')]
    public $name = '';

    public function createBoard()
    {
        $this->validate();

        $board = Board::create([
            'name' => $this->name,
            'user_id' => auth('sanctum')->user()->getAuthIdentifier()
        ]);

        $this->dispatch('created');

        return redirect()->route('web.board.show', $board);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.create-board');
    }
}