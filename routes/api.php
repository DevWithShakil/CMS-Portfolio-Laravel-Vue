<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\BlogCategoryController;

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



