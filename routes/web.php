<?php

use App\Http\Controllers\GoogleController;
use App\Http\Controllers\FacebookController;
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
use App\Http\Controllers\StoryController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ChatController;

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
    Route::resource('posts', PostController::class)->except(['index', 'create', 'show']);

    // Comments
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::patch('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    // // Reactions
    Route::post('/posts/{post}/react', [ReactionController::class, 'toggle'])->name('posts.react');
    Route::post('/comments/{comment}/react', [ReactionController::class, 'toggleComment'])->name('comments.react');

    // // Admin Moderation
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index')->middleware('can:acces-admin');
    Route::post('/admin/posts/{post}/approve', [AdminController::class, 'approve'])->name('admin.approve');
    Route::post('/admin/posts/{post}/reject', [AdminController::class, 'reject'])->name('admin.reject');
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

Route::post('/stories/store', [StoryController::class, 'store'])->name('stories.store');
// add a friend
Route::get('/friends/add', [FriendshipController::class, 'addPage'])->name('friends.page');
Route::post('/friends/add/{id}', [FriendshipController::class, 'add'])->name('friends.add');
Route::post('/friends/accept/{id}', [FriendshipController::class, 'accept'])->name('friends.accept');
Route::post('/friends/reject/{id}', [FriendshipController::class, 'reject'])->name('friends.reject');

Route::get('/messagerie/index', [ChatController::class, 'show'])->name('messagerie.index');
Route::post('/chat/send', [ChatController::class, 'send'])->middleware('auth')->name('chat.send');
Route::get('/chat/messages/{conversation}', [ChatController::class, 'fetchMessages'])->middleware('auth')->name('chat.messages');

// Google OAuth Routes
Route::get('/auth/google/redirect', [GoogleController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('google.callback');


// Facebook OAuth Routes
Route::get('/auth/facebook/redirect', [FacebookController::class, 'redirect'])
    ->name('facebook.redirect');

Route::get('/auth/facebook/callback', [FacebookController::class, 'callback'])
    ->name('facebook.callback');

require __DIR__ . '/auth.php';
