<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    // Get settings
    public function index()
    {
        $setting = Setting::first();

        if (!$setting) {
            return response()->json([
                'site_title' => 'My Portfolio',
                'email' => 'admin@example.com'
            ]);
        }

        $admin = User::where('is_admin', true)->first();
        $adminEmail = $admin ? $admin->email : 'admin@example.com';

        $setting->email = $adminEmail;

        return response()->json($setting);
    }

    // Update settings
    public function update(Request $request, string $id)
    {
        $setting = Setting::findOrFail($id);

        $validated = $request->validate([
            'site_title'    => 'nullable|string|max:255',
            'hero_title'    => 'nullable|string|max:255',
            'hero_subtitle' => 'nullable|string|max:255',
            'about'         => 'nullable|string',
            'facebook'      => 'nullable|string',
            'youtube'       => 'nullable|string',
            'github'        => 'nullable|string',
            'linkedin'      => 'nullable|string',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'resume_file'   => 'nullable|mimes:pdf,doc,docx|max:5120',
        ]);

        $data = $request->except(['profile_image', 'resume_file']);

        if ($request->hasFile('profile_image')) {
            if ($setting->profile_image) {
                $oldPath = str_replace('/storage/', '', $setting->profile_image);
                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }
            $path = $request->file('profile_image')->store('settings', 'public');
            $data['profile_image'] = '/storage/' . $path;
        }

        if ($request->hasFile('resume_file')) {
            if ($setting->resume_file) {
                $oldPath = str_replace('/storage/', '', $setting->resume_file);
                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }
            $path = $request->file('resume_file')->store('resumes', 'public');
            $data['resume_file'] = '/storage/' . $path;
        }

        $setting->update($data);

        // আপডেটেড অবজেক্টের সাথে ইমেল আবার পাঠিয়ে দিচ্ছি
        $admin = User::where('is_admin', true)->first();
        $setting->email = $admin ? $admin->email : 'admin@example.com';

        return response()->json([
            'message' => 'Settings updated successfully',
            'data' => $setting,
        ]);
    }

    // Store (Create)
    public function store(Request $request)
    {
        if (Setting::count() > 0) {
            return response()->json(['message' => 'Setting already exists'], 400);
        }

        $setting = Setting::create($request->all());

        return response()->json([
            'message' => 'Setting created successfully',
            'data' => $setting
        ], 201);
    }
}
