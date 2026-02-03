<?php

use App\Http\Controllers\MessagerieController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FriendshipController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ReactionController;
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [App\Http\Controllers\PostController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Posts
    Route::resource('posts', App\Http\Controllers\PostController::class)->except(['index', 'create', 'show']);

    // Comments
    Route::post('/posts/{post}/comments', [App\Http\Controllers\CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [App\Http\Controllers\CommentController::class, 'destroy'])->name('comments.destroy');

    // Reactions
    Route::post('/posts/{post}/react', [App\Http\Controllers\ReactionController::class, 'toggle'])->name('posts.react');

    // Admin Moderation
    Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.index');
    Route::post('/admin/posts/{post}/approve', [App\Http\Controllers\AdminController::class, 'approve'])->name('admin.approve');
    Route::post('/admin/posts/{post}/reject', [App\Http\Controllers\AdminController::class, 'reject'])->name('admin.reject');
});

// userController routes



Route::get('/users', [UserController::class, 'index'])
    ->name('users.index')
    ->middleware('auth');

Route::get('/users/{user}', [UserController::class, 'show'])
    ->name('users.show')
    ->middleware('auth');

// Friends
Route::get('/friends', [FriendshipController::class, 'index'])
    ->name('friends.index')
    ->middleware('auth');


// add a friend
Route::get('/friends/add', [FriendshipController::class, 'addPage'])->name('friends.page');
Route::post('/friends/add/{id}', [FriendshipController::class, 'add'])->name('friends.add');
Route::post('/friends/accept/{id}', [FriendshipController::class, 'accept'])->name('friends.accept');
Route::post('/friends/reject/{id}', [FriendshipController::class, 'reject'])->name('friends.reject');

Route::get('/messagerie/index', [MessagerieController::class, 'show'])->name('messagerie.index');


require __DIR__ . '/auth.php';
