<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;

//  Public Routes.
Route::post('/signup', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

// // Protected Routes.
// Route::middleware('auth:sanctum')->get('/students', [StudentController::class, 'index']);
// Route::middleware('auth:sanctum')->get('/students/{id}', [StudentController::class, 'show']);


// Protected Routes with Group.
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/students', [StudentController::class, 'index']);
    Route::get('/students/{id}', [StudentController::class, 'show']);
    Route::post('/students', [StudentController::class, 'store']);
    Route::put('/students/{id}', [StudentController::class, 'update']);
    Route::delete('/students/{id}', [StudentController::class, 'destroy']);
    Route::get('/students/search/{city}', [StudentController::class, 'search']);
    Route::post('/logout', [UserController::class, 'logout']);
});
