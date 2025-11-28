<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Project::query();

        if ($request->search) {
            $query->where('title', 'like', "%{$request->search}%");
        }

        return $query->orderBy('id', 'desc')->paginate(5);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string',
            'slug'        => 'required|string|unique:projects',
            'description' => 'required|string',
            'tech_stack'  => 'required|string',
            'github_link' => 'nullable|url',
            'live_link'   => 'nullable|url',
            'thumbnail'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);


        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('projects', 'public');
            $validated['thumbnail'] = '/storage/' . $path;
        }

        $project = Project::create($validated);

        return response()->json([
            'message' => 'Project created successfully',
            'data' => $project,
        ], 201);
    }

    public function show(string $id)
    {
        $project = Project::findOrFail($id);
        return response()->json(['data' => $project], 200);
    }

    public function update(Request $request, string $id)
    {
        $project = Project::findOrFail($id);

        $validated = $request->validate([
            'title'       => 'required|string',
            'slug'        => 'required|string|unique:projects,slug,' . $id,
            'description' => 'required|string',
            'tech_stack'  => 'required|string',
            'github_link' => 'nullable|url',
            'live_link'   => 'nullable|url',
            'thumbnail'   => 'nullable',
        ]);


        if ($request->hasFile('thumbnail')) {

            if ($project->thumbnail) {
                $oldPath = str_replace('/storage/', '', $project->thumbnail);
                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }

            $path = $request->file('thumbnail')->store('projects', 'public');
            $validated['thumbnail'] = '/storage/' . $path;
        }

        $project->update($validated);

        return response()->json([
            'message' => 'Project updated successfully',
            'data' => $project
        ], 200);
    }

    public function destroy(string $id)
    {
        $project = Project::findOrFail($id);

        if ($project->thumbnail) {
            $oldPath = str_replace('/storage/', '', $project->thumbnail);
            if (Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
        }

        $project->delete();

        return response()->json(['message' => 'Project deleted successfully'], 200);
    }
}
