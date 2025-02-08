<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FollowController;

// Admin Related Routes
Route::get('/admin-page', function() {
    return 'Only admins are allowed to access this page.';
})->middleware('can:visitAdminPage');

// User Related Routes
Route::get('/', [UserController::class, 'index']);
Route::post('/register', [UserController::class, 'register'])->middleware('guest');
Route::post('/login', [UserController::class, 'login'])->middleware('guest');
Route::post('/logout', [UserController::class, 'logout'])->middleware('MustBeLoggedIn');
Route::get('/manage-avatar', [UserController::class, 'showAvatarForm'])->middleware('MustBeLoggedIn');
Route::post('/manage-avatar', [UserController::class, 'storeAvatar'])->middleware('MustBeLoggedIn');

// Follow Related Routes
Route::post('/create-follow/{user:username}', [FollowController::class, 'createFollow'])->middleware('MustBeLoggedIn');
Route::post('/remove-follow/{user:username}', [FollowController::class, 'removeFollow'])->middleware('MustBeLoggedIn');

// Post Related Routes
Route::get('/create-post', [PostController::class, 'showCreatePost'])->middleware('MustBeLoggedIn');
Route::post('/create-post', [PostController::class, 'storeCreatedPost'])->middleware('MustBeLoggedIn');;
Route::get('/post/{post}', [PostController::class, 'viewSinglePost']);
Route::delete('/post/{post}', [PostController::class, 'destroy'])->middleware('can:delete,post');
Route::get('/post/{post}/edit', [PostController::class, 'showEditForm'])->middleware('can:update,post');;
Route::put('/post/{post}', [PostController::class, 'update'])->middleware('can:update,post');

// Profile Related Routes
Route::get('/profile/{user:username}', [UserController::class, 'showProfile']);
Route::get('/profile/{user:username}/followers', [UserController::class, 'showFollowers']);
Route::get('/profile/{user:username}/following', [UserController::class, 'showFollowing']);

