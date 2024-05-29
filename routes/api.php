<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\ListsController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::match(['get', 'post'], '/board', function (Request $request) {
    return $request->board();
})->middleware('auth:sanctum');

Route::match(['get', 'post'], '/lists', function (Request $request) {
    return $request->lists();
})->middleware('auth:sanctum');

Route::apiResources([
    'board' => BoardController::class,
    'lists' => ListsController::class,
]);
