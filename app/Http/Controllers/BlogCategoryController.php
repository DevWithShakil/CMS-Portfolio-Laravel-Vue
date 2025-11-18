<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlogCategory;

class BlogCategoryController extends Controller
{
    public function index()
    {
        return BlogCategory::all();
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:blog_categories',
        ]);

        $category = BlogCategory::create($validate);

        return response()->json([
            'message' => 'Blog Category created successfully',
            'data' => $category,
        ], 201);
    }

    public function show($id)
    {
       return BlogCategory::findOrFail($id);
    }

    public function update(Request $request, string $id)
    {
        $category = BlogCategory::findOrFail($id);
        $category->update($request->validate([
            'name' => 'required',
            'slug' => 'required|unique:blog_categories',
        ]));

        return response()->json([
            'message' => 'Blog Category updated successfully',
            'data' => $category,
        ], 201);
    }

    public function destroy($id)
    {
        $category = BlogCategory::findOrFail($id);
        $category->delete();

        return response()->json([
            'message' => 'Blog Category deleted successfully',
            'data' => $category,
        ], 201);
    }
}
