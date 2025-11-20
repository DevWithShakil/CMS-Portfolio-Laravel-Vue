<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;

use App\Http\Controllers\{
    ProjectController,
    SkillController,
    ExperienceController,
    EducationController,
    ContactController,
    SettingController,
    BlogCategoryController,
    BlogController,
    AuthController
};

// Rate Limiter
RateLimiter::for('api', function ($request) {
    return Limit::perMinute(60)->by($request->ip());
});

// Test Route
Route::get('/test', fn() => ['message' => 'API working fine!']);

// -----------------------------------------
// 📌 PUBLIC API (Portfolio Frontend)
// -----------------------------------------
Route::prefix('public')->group(function () {
    Route::get('/projects', [ProjectController::class, 'index']);
    Route::get('/projects/{id}', [ProjectController::class, 'show']);
});

// -----------------------------------------
// 📌 AUTH
// -----------------------------------------
Route::post('/login', [AuthController::class, 'login']);

// -----------------------------------------
// 📌 ADMIN API (Protected CRUD Routes)
// -----------------------------------------
Route::middleware('auth:sanctum')->prefix('admin')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::apiResource('projects', ProjectController::class);
    Route::apiResource('skills', SkillController::class);
    Route::apiResource('experiences', ExperienceController::class);
    Route::apiResource('education', EducationController::class);
    Route::apiResource('contacts', ContactController::class);
    Route::apiResource('settings', SettingController::class);
    Route::apiResource('blogs', BlogController::class);
    Route::apiResource('categories', BlogCategoryController::class);
});
