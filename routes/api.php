<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\TaskController;

Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);

Route::middleware('auth:sanctum')->group(function(){

    Route::post('/logout',[AuthController::class,'logout']);

    Route::apiResource('projects', ProjectController::class);
    Route::apiResource('tasks', TaskController::class);
});