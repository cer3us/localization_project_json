<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\ProjectController;

Route::apiResource('v1/projects', ProjectController::class)
    ->except(['update'])
    ->middleware('auth:sanctum');

Route::patch('v1/projects/{project}', [ProjectController::class, 'update'])
    ->name('projects.update')
    ->middleware('auth:sanctum');
