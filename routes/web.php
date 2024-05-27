<?php

use App\Models\Board;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\BoardResource;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/home', function () {
        return redirect('/board');
    })->name('home');

    Route::prefix('board')->group(function () {
        Route::get('/', function () {
            $boards = Auth::user()->boards;

            return view('board.index', [
                'boards' => $boards,
            ]);
        })->name('board.index');
        Route::get('/create', function () {
            return view('pages.create-board');
        })->name('board.create');
        Route::get('/{board}', function (Board $board) {
            $board = new BoardResource($board);

            return view('board.show', [
                'board' => $board,
            ]);
        })->name('board.show');
    });
});require __DIR__.'/socialstream.php';