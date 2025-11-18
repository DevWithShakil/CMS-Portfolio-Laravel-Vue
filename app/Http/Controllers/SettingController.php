<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    // Get all settings from the database
    public function index()
    {
        return Setting::first();
    }

    // Post a new setting to the database

    public function store(Request $request)
    {
        // create if it doesn't exist
        if (Setting::count() > 0) {
            return response()->json([
                'message' => 'Setting already exists',
                'data' => Setting::first(),
            ], 400);
        } else {
            $setting = Setting::create($request->all());
            return response()->json([
                'message' => 'Setting created successfully',
                'data'=> $setting
            ],201);

        }
    }

    // Update a setting in the database
    public function update(Request $request, string $id)
    {
        $setting = Setting::findOrFail($id);
        $setting->update($request->all());
        return response()->json([
            'message' => 'Setting updated successfully',
            'data' => $setting,
        ]);
    }
}
