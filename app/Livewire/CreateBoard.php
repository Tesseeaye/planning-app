<?php

namespace App\Livewire;

use App\Models\Board;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
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
            'user_id' => Auth::user()->id
        ]);

        $this->dispatch('created');

        return redirect()->route('board.show', $board);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.create-board');
    }
}
