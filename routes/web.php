<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;

// Welcome Page
Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Profile Routes
Route::get('/profile', [ProfileController::class, 'show'])->name('profile')->middleware('auth');
Route::put('/profile', [ProfileController::class, 'update'])->middleware('auth');

// Task Routes (Protected by auth middleware)
Route::middleware(['auth'])->group(function () {
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
    Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
    Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    Route::patch('/tasks/{task}/complete', [TaskController::class, 'complete'])->name('tasks.complete');
    Route::patch('/tasks/{task}/incomplete', [TaskController::class, 'incomplete'])->name('tasks.incomplete');
});

// Dashboard Route (Protected by auth middleware)
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard')->middleware('auth');

// Catch-all route for Vue Router
Route::get('/{any}', function () {
    return view('app');
})->where('any', '.*');

// Fallback route for undefined routes
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});