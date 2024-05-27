<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BoardController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::match(['get', 'post'], '/board', function (Request $request) {
    return $request->board();
})->middleware('auth:sanctum');

Route::apiResources([
    'board' => BoardController::class,
]);
