<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\UserController;

Route::controller(UserController::class)->prefix('v1/users')->group(function () {
    Route::get('/', 'list')->name('users.list')->middleware('auth:sanctum');
});
