<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    // Get blogs with Search and Pagination
    public function index(Request $request)
    {
        $query = Blog::with('category');

        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        return $query->latest()->paginate(10);
    }

    // Store new blog with Image Upload
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id'  => 'required|exists:blog_categories,id',
            'title'        => 'required|string|max:255',
            'slug'         => 'required|string|unique:blogs,slug',
            'content'      => 'required',
            'is_published' => 'nullable|boolean',
            'thumbnail'    => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($request->hasFile('thumbnail')) {

            $path = $request->file('thumbnail')->store('blogs', 'public');
            $validated['thumbnail'] = '/storage/' . $path; // DB তে পাথ সেভ হবে
        }

        $blog = Blog::create($validated);

        return response()->json([
            'message' => 'Blog created successfully',
            'data' => $blog,
        ], 201);
    }

    // Show single blog
    public function show($id)
    {
        $blog = Blog::with('category')->findOrFail($id);

        return response()->json([
            'message' => 'Blog found successfully',
            'data' => $blog,
        ], 200);
    }

    // Update blog with Image Replacement
    public function update(Request $request, string $id)
    {
        $blog = Blog::findOrFail($id);

        $validated = $request->validate([
            'category_id'  => 'required|exists:blog_categories,id',
            'title'        => 'required|string|max:255',
            'slug'         => 'required|string|unique:blogs,slug,' . $id,
            'content'      => 'required',
            'is_published' => 'nullable|boolean',
            'thumbnail'    => 'nullable',
        ]);

        if ($request->hasFile('thumbnail')) {

            if ($blog->thumbnail) {
                $oldPath = str_replace('/storage/', '', $blog->thumbnail);
                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }

            $path = $request->file('thumbnail')->store('blogs', 'public');
            $validated['thumbnail'] = '/storage/' . $path;
        }

        $blog->update($validated);

        return response()->json([
            'message' => 'Blog updated successfully',
            'data' => $blog,
        ], 200);
    }

    // Delete blog and associated image
    public function destroy(string $id)
    {
        $blog = Blog::findOrFail($id);
        if ($blog->thumbnail) {
            $oldPath = str_replace('/storage/', '', $blog->thumbnail);
            if (Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
        }

        $blog->delete();

        return response()->json([
            'message' => 'Blog deleted successfully',
        ], 200);
    }
}
