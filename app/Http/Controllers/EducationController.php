<?php

namespace App\Http\Controllers;

use App\Models\Education;
use Illuminate\Http\Request;

class EducationController extends Controller
{
    public function index(Request $request)
    {
        $query = Education::query();

        if ($request->search) {
            $query->where('degree', 'like', '%' . $request->search . '%')
                  ->orWhere('institution', 'like', '%' . $request->search . '%');
        }

        return $query->latest()->paginate(10);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'degree'      => 'required|string|max:255',
            'institution' => 'required|string|max:255',
            'duration'    => 'required|string|max:50',
            'description' => 'required|string',
        ]);

        $education = Education::create($validated);

        return response()->json([
            'message' => 'Education created successfully',
            'data'    => $education,
        ], 201);
    }

    public function show(string $id)
    {
        $education = Education::findOrFail($id);
        return response()->json(['data' => $education], 200);
    }

    public function update(Request $request, string $id)
    {
        $education = Education::findOrFail($id);

        $validated = $request->validate([
            'degree'      => 'required|string|max:255',
            'institution' => 'required|string|max:255',
            'duration'    => 'required|string|max:50',
            'description' => 'required|string',
        ]);

        $education->update($validated);

        return response()->json([
            'message' => 'Education updated successfully',
            'data'    => $education,
        ], 200);
    }

    public function destroy(string $id)
    {
        $education = Education::findOrFail($id);
        $education->delete();
        return response()->json(['message' => 'Deleted successfully'], 200);
    }
}
