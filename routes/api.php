<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\BlogCategoryController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;

// Rate Limiter for API requests
RateLimiter::for('api', function ($request) {
    return Limit::perMinute(60)->by($request->ip());
});


Route::get('/test', function () {
    return ['message' => 'API working fine!'];
});

Route::apiResource('projects', ProjectController::class);
Route::apiResource('skills', SkillController::class);
Route::apiResource('experiences', ExperienceController::class);
Route::apiResource('education', EducationController::class);
Route::apiResource('contacts', ContactController::class);
Route::apiResource('settings', SettingController::class);
Route::apiResource('categories', BlogCategoryController::class);
Route::apiResource('blogs', BlogController::class);


// Public Route
Route::post('/login', [AuthController::class, 'login']);

// Protected Routes
Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    // All CMS Routes (admin only)
    Route::apiResource('projects', ProjectController::class);
    Route::apiResource('skills', SkillController::class);
    Route::apiResource('experiences', ExperienceController::class);
    Route::apiResource('education', EducationController::class);
    Route::apiResource('contacts', ContactController::class);
    Route::apiResource('settings', SettingController::class);
    Route::apiResource('blogs', BlogController::class);
    Route::apiResource('categories', BlogCategoryController::class);
});




