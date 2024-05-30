<?php

use App\Models\Project;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\ProjectResource;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
         // Retrieve a list of the user's projects.
        //$projects = $this->post(route('project.index'));

        //return view('dashboard', [
        //        'projects' => $projects,
        //]);
    })->name('dashboard');

    Route::prefix('project')->group(function () {
        Route::get('/create', function () {

        })->name('create.project');
        Route::get('/{project}', function (Project $project) {
            $project = new ProjectResource($project);

            //return view('project.show', [
             //   'project' => $project,
            //]);
        })->name('show.project');
    });
});require __DIR__.'/socialstream.php';
