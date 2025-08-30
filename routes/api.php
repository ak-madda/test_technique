<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    
    Route::apiResource('projects', ProjectController::class);
    
    Route::get('/projects/{project}/tasks', [TaskController::class, 'projectTasks']);
    Route::post('/projects/{project}/tasks', [TaskController::class, 'store']);
    
    Route::apiResource('tasks', TaskController::class)->except(['store']);
    Route::patch('/tasks/{task}/status', [TaskController::class, 'updateStatus']);
    
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
}
);