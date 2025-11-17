<?php

use App\Http\Controllers\ProjectController;

Route::get('/test', function () {
    return ['message' => 'API working fine!'];
});

Route::apiResource('projects', ProjectController::class);
