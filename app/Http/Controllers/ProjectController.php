<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str; //

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

    if ($request->has('limit')) {
        return $query->latest()->limit($request->limit)->get();
    }

    return $query->orderBy('id', 'desc')->paginate(5);
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'title'       => 'required|string',
            'slug'        => 'nullable|string|unique:projects',
            'description' => 'required|string',
            'tech_stack'  => 'required|string',
            'github_link' => 'nullable|url',
            'live_link'   => 'nullable|url',
            'thumbnail'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if (!empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['slug']);
        } else {
            $validated['slug'] = Str::slug($validated['title']);
        }


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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $project = Project::findOrFail($id);
        return response()->json(['data' => $project], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $project = Project::findOrFail($id);

        $validated = $request->validate([
            'title'       => 'required|string',
            'slug'        => 'nullable|string|unique:projects,slug,' . $id,
            'description' => 'required|string',
            'tech_stack'  => 'required|string',
            'github_link' => 'nullable|url',
            'live_link'   => 'nullable|url',
            'thumbnail'   => 'nullable',
        ]);


        if (!empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['slug']);
        } else {
            $validated['slug'] = Str::slug($validated['title']);
        }


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

    /**
     * Remove the specified resource from storage.
     */
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
