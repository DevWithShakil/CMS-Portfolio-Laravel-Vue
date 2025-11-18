<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SkillController;

Route::get('/test', function () {
    return ['message' => 'API working fine!'];
});

Route::apiResource('projects', ProjectController::class);
Route::apiResource('skills', SkillController::class);

