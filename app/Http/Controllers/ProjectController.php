<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Http\Resources\ProjectResource;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreProjectRequest;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ProjectResource::collection(Project::where('user_id', auth('sanctum')->user()->getAuthIdentifier())->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated = $request->safe()->only(['name']);

        $project = Project::create([
            'name' => $validated['name'],
            'user_id' => auth('sanctum')->user()->getAuthIdentifier(),
        ]);

        return redirect()->route('project.show', $project);
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return new ProjectResource($project);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreProjectRequest $request, Project $project): RedirectResponse
    {
        $validated = $request->validated();

        $validated = $request->safe()->only(['name']);

        $project->update([
            'name' => $validated['name'],
        ]);

        return redirect()->route('project.show', $project);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $name = $project->name;

        $project->delete($project);

        return response()->json([
            'message' => 'Project \'' . $name . '\' was deleted successfully.'
        ]);
    }
}
