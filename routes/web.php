<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// User Related Routes
Route::get('/', [UserController::class, 'index']);
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout']);

// Post Related Routes
Route::get('/create-post', [PostController::class, 'showCreatePost']);
Route::post('/create-post', [PostController::class, 'storeCreatedPost']);
Route::get('/post/{post}', [PostController::class, 'viewSinglePost']);
