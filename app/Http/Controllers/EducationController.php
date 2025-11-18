<?php

namespace App\Http\Controllers;
use App\Models\Education;

use Illuminate\Http\Request;

class EducationController extends Controller
{
    // Get all educations from the database
    public function index()
    {
        return Education::all();
    }

    // Post a new education to the database
    public function store(Request $request)
    {
        $validated = $request->validate([
            'degree' => 'required',
            'institution' => 'required',
            'duration' => 'required',
            'description' => 'required',
        ]);

        // Insert the education into the database
        $education = Education::create($validated);

        return response()->json([
            'message' => 'Education created successfully',
            'data' => $education,
        ], 201);
    }

    // Get a single education from the database
    public function show(string $id)
    {
        // Get the education from the database
        $education = Education::findOrFail($id);

        return response()->json([
            'message' => 'Education found successfully',
            'data' => $education,
        ], 201);
    }

    // Update a education in the database
    public function update(Request $request, string $id)
    {
        // Update education from the database
        $education = Education::findOrFail($id);
        $education->update($request->validate([
            'degree' => 'required',
            'institution' => 'required',
            'duration' => 'required',
            'description' => 'required',
        ]));

        return response()->json([
            'message' => 'Education updated successfully',
            'data' => $education,
        ], 201);
    }

    // Delete a education from the database
    public function destroy(string $id)
    {
        // Delete education from the database
        $education = Education::findOrFail($id);
        $education->delete();

        return response()->json([
            'message' => 'Education deleted successfully',
            'data' => $education,
        ], 201);
    }
}
