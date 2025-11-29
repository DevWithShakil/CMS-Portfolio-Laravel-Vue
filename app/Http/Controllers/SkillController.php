<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Skill;

class SkillController extends Controller
{
 public function index(Request $request)
{
    $query = Skill::query();

    if ($request->search) {
        $query->where('name', 'like', "%{$request->search}%");
    }

    if ($request->has('all')) {
        return $query->orderBy('percentage', 'desc')->get();
    }

    return $query->latest()->paginate(10);
}

    // Post a new skill to the database
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'category' => 'required',
            'percentage' => 'required',
        ]);

        // Insert the skill into the database
        $skill = Skill::create($validated);

        return response()->json([
            'message' => 'Skill created successfully',
            'data' => $skill,
        ], 201);
    }

    // Get a single skill from the database
    public function show(string $id)
    {
        // Get the skill from the database
        $skill = Skill::findOrFail($id);

        return response()->json([
            'message' => 'Skill found successfully',
            'data' => $skill,
        ], 201);
    }

    // Update a skill in the database
    public function update(Request $request, string $id)
    {
        // Update skill from the database
        $skill = Skill::findOrFail($id);
        $skill->update($request->validate([
            'name' => 'required',
            'category' => 'required',
            'percentage' => 'required',
        ]));

        return response()->json([
            'message' => 'Skill updated successfully',
            'data' => $skill,
        ], 201);
    }

    // Delete a skill from the database
    public function destroy(string $id)
    {
        // Delete skill from the database
        $skill = Skill::findOrFail($id);
        $skill->delete();

        return response()->json([
            'message' => 'Skill deleted successfully',
            'data' => $skill,
        ], 201);
    }
}
