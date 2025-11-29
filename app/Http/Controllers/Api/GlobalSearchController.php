<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Skill;
use App\Models\Blog;
use App\Models\Contact;

class GlobalSearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('q');

        // যদি কুয়েরি না থাকে বা খুব ছোট হয়
        if (!$query || strlen($query) < 2) {
            return response()->json([]);
        }

        // 1. Search Projects
        $projects = Project::where('title', 'like', "%{$query}%")
            ->select('id', 'title', 'thumbnail') // নির্দিষ্ট কলাম সিলেক্ট করুন
            ->limit(3)->get()
            ->map(function($item) {
                return [
                    'type' => 'Project',
                    'url' => '/admin/projects',
                    'data' => $item
                ];
            });

        // 2. Search Skills
        $skills = Skill::where('name', 'like', "%{$query}%")
            ->select('id', 'name', 'category')
            ->limit(3)->get()
            ->map(function($item) {
                return [
                    'type' => 'Skill',
                    'url' => '/admin/skills',
                    'data' => $item
                ];
            });

        // 3. Search Blogs
        $blogs = Blog::where('title', 'like', "%{$query}%")
            ->select('id', 'title', 'thumbnail')
            ->limit(3)->get()
            ->map(function($item) {
                return [
                    'type' => 'Blog',
                    'url' => '/admin/blogs',
                    'data' => $item
                ];
            });

        // ✅ FIX: concat এবং values() ব্যবহার করে ক্লিন অ্যারে তৈরি করা
        $results = $projects->concat($skills)->concat($blogs)->values();

        return response()->json($results);
    }

    // ... notifications method (আগেরটা ঠিক আছে) ...
    public function notifications() {
        $unreadCount = Contact::where('is_seen', false)->count();
        $latest = Contact::where('is_seen', false)->latest()->limit(5)->get();
        return response()->json(['count' => $unreadCount, 'messages' => $latest]);
    }

    // app/Http/Controllers/Api/GlobalSearchController.php

public function publicSearch(Request $request)
{
    $query = $request->input('q');

    if (!$query || strlen($query) < 2) {
        return response()->json([]);
    }

    $operator = 'ILIKE';

    // 1. Search Projects
    $projects = Project::where('title', $operator, "%{$query}%")
        ->orWhere('tech_stack', $operator, "%{$query}%")
        ->select('id', 'title', 'thumbnail', 'slug')
        ->limit(5)->get()
        ->map(fn($item) => ['type' => 'Project', 'url' => '#portfolio', 'data' => $item]);

    // 2. Search Skills
    $skills = Skill::where('name', $operator, "%{$query}%")
        ->select('id', 'name', 'category')
        ->limit(5)->get()
        ->map(fn($item) => ['type' => 'Skill', 'url' => '#skills', 'data' => $item]);

    // 3. Search Published Blogs Only
    $blogs = Blog::where('is_published', true)
        ->where('title', $operator, "%{$query}%")
        ->select('id', 'title', 'thumbnail', 'slug')
        ->limit(5)->get()
        ->map(fn($item) => ['type' => 'Blog', 'url' => '#blog', 'data' => $item]);

    $results = $projects->concat($skills)->concat($blogs)->values();

    return response()->json($results);
}
}
