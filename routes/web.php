<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// User Related Routes
Route::get('/', [UserController::class, 'index']);
Route::post('/register', [UserController::class, 'register'])->middleware('guest');
Route::post('/login', [UserController::class, 'login'])->middleware('guest');
Route::post('/logout', [UserController::class, 'logout'])->middleware('MustBeLoggedIn');

// Post Related Routes
Route::get('/create-post', [PostController::class, 'showCreatePost'])->middleware('MustBeLoggedIn');
Route::post('/create-post', [PostController::class, 'storeCreatedPost'])->middleware('MustBeLoggedIn');;
Route::get('/post/{post}', [PostController::class, 'viewSinglePost']);
Route::delete('/post/{post}', [PostController::class, 'destroy']);

// Profile Related Routes
Route::get('/profile/{user:username}', [UserController::class, 'showProfile']);

