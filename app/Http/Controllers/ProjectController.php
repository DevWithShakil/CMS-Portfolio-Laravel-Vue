<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(Request $request)
{
    $query = Project::query();

    if ($request->search) {
        $query->where('title', 'like', "%{$request->search}%");
    }

    return $query->orderBy('id', 'desc')->paginate(5);
}


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'slug' => 'required|unique:projects',
            'description' => 'required',
            'tech_stack' => 'required',
            'thumbnail' => 'nullable',
            'github_link' => 'nullable',
            'live_link' => 'nullable',
        ]);


        // Insert the project into the database
        $project = Project::create($validated);

        return response()->json([
            'message' => 'Project created successfully',
            'data' => $project,
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        // Get the project from the database
        $project = Project::findOrFail($id);

        return response()->json([
            'message' => 'Project found successfully',
            'data' => $project,
        ],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    $project = Project::findOrFail($id);

    $validated = $request->validate([
        'title' => 'required',
        'slug' => 'required|unique:projects,slug,' . $id,
        'description' => 'required',
        'tech_stack' => 'required',
        'thumbnail' => 'nullable|string',
        'github_link' => 'nullable|string',
        'live_link' => 'nullable|string',
    ]);

    $project->update($validated);

    return response()->json([
        'message' => 'Project updated successfully',
        'data' => $project
    ], 200);
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Delete project from the database
        $project = Project::findOrFail($id);
        $project->delete();

        return response()->json([
            'message' => 'Project deleted successfully',
            'data' => $project,
        ], 200);
    }
}
