<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\ExperienceController;

Route::get('/test', function () {
    return ['message' => 'API working fine!'];
});

Route::apiResource('projects', ProjectController::class);
Route::apiResource('skills', SkillController::class);
Route::apiResource('experiences', ExperienceController::class);


