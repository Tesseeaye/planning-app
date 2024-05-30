<?php

use App\Models\User;
use App\Models\Project;
use function Pest\Laravel\actingAs;

use App\Http\Resources\ProjectResource;

beforeEach(function () {
    actingAs(User::factory()->create());
});

test('"Project" list can be retrieved', function () {
    Project::factory()->count(3)->for(auth('sanctum')->user(), 'author')->create();

    $response = $this->getJson(route('project.index'));

    $response->assertStatus(200)
        ->assertJson([
            'data' => ProjectResource::collection(Project::where('user_id', auth('sanctum')->user()->getAuthIdentifier())->get())->resolve()
        ]);

    $responseData = $response->json('data');
    $this->assertCount(3, $responseData);
});

test('"Project" can be stored', function () {
    $response = $this->postJson(route('project.store'), [
        'name' => 'Lorem Ipsum',
    ]);

    $this->assertDatabaseHas('projects', [
        'name' => 'Lorem Ipsum',
    ]);

    $response
        ->assertStatus(302)
        ->assertRedirectToRoute('project.show', Project::where('name', 'Lorem Ipsum')->firstOrFail());
});

test('"Project" can be shown', function () {
    $project = Project::factory()->create();

    $response = $this->getJson(route('project.show', $project));

    $response
        ->assertStatus(200)
        ->assertJson([
            'data' => (new ProjectResource($project))->resolve()
        ]);
});

test('"Project" can be updated', function () {
    $project = Project::factory()->create();

    $response = $this->putJson(route('project.update', $project), [
        'name' => 'Changed name',
    ]);

    $response
        ->assertStatus(302)
        ->assertRedirectToRoute('project.show', Project::where('name', 'Changed name')->firstOrFail());
});

test('"Project" can be destroyed', function () {
    $project = Project::factory()->create();

    $response = $this->deleteJson(route('project.destroy', $project));

    $this->assertModelMissing($project);

    $response
        ->assertStatus(200)
        ->assertJson(['message' => 'Project \'' . $project->name . '\' was deleted successfully.']);
});