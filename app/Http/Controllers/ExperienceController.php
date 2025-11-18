<?php

namespace App\Http\Controllers;
use App\Models\Experience;

use Illuminate\Http\Request;

class ExperienceController extends Controller
{
    public function index()
    {
        return Experience::all();
    }

    // Post a new experience to the database
    public function store(Request $request)
    {
        $validated = $request->validate([
            'position' => 'required',
            'company' => 'required',
            'duration' => 'required',
            'description' => 'required',
        ]);

        // Insert the experience into the database
        $experience = Experience::create($validated);

        return response()->json([
            'message' => 'Experience created successfully',
            'data' => $experience,
        ], 201);
    }

    // Get a single experience from the database
    public function show(string $id)
    {
        // Get the experience from the database
        $experience = Experience::findOrFail($id);

        return response()->json([
            'message' => 'Experience found successfully',
            'data' => $experience,
        ], 201);
    }

    // Update a experience in the database
    public function update(Request $request, string $id)
    {
        // Update experience from the database
        $experience = Experience::findOrFail($id);
        $experience->update($request->validate([
            'position' => 'required',
            'company' => 'required',
            'duration' => 'required',
            'description' => 'required',
        ]));

        return response()->json([
            'message' => 'Experience updated successfully',
            'data' => $experience,
        ], 201);
    }

    // Delete a experience from the database
    public function destroy(string $id)
    {
        // Delete experience from the database
        $experience = Experience::findOrFail($id);
        $experience->delete();

        return response()->json([
            'message' => 'Experience deleted successfully',
            'data' => $experience,
        ], 201);
    }

}
