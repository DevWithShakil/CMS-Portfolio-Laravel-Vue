<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;

class BlogController extends Controller
{
    public function index()
    {
        return Blog::with('category')->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:blog_categories,id',
            'title' => 'required',
            'slug'  => 'required|unique:blogs',
            'content' => 'required',
            'thumbnail' => 'nullable',
            'status' => 'nullable|boolean'
        ]);

        $blog = Blog::create($validated);

        return response()->json([
            'message' => 'Blog created successfully',
            'data' => $blog,
        ], 201);
    }

    public function show($id)
    {
        $blog = Blog::with('category')->findOrFail($id);

        return response()->json([
            'message' => 'Blog found successfully',
            'data' => $blog,
        ], 201);
    }

    public function update(Request $request, string $id)
    {
        $blog = Blog::findOrFail($id);
        $blog->update($request->all());

        return response()->json([
            'message' => 'Blog updated successfully',
            'data' => $blog,
        ], 201);
    }

    public function destroy(string $id)
    {
        $blog = Blog::findOrFail($id);
        $blog->delete();

        return response()->json([
            'message' => 'Blog deleted successfully',
            'data' => $blog,
        ], 201);
    }
}
