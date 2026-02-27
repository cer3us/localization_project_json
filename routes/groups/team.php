<?php

use App\Http\Controllers\Api\v1\ProjectController;
use Illuminate\Support\Facades\Route;

Route::controller(ProjectController::class)->middleware('auth:sanctum')->prefix('v1/team')->group(function () {
    Route::get('projects', 'listProjects')->name('team.projects.list');
    Route::post('assign-performer', 'assignPerformer')->name('team.assign.performer');
});
