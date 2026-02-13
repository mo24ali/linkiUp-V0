<?php

use App\Http\Controllers\GoogleController;
use App\Http\Controllers\FacebookController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ReactionController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\FriendshipController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\MessagerieController;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\QrController;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [PostController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');
});

// Friends Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/friends', [FriendshipController::class, 'index'])->name('friends.index');
    Route::get('/friends/add', [FriendshipController::class, 'addPage'])->name('friends.page');
    Route::post('/friends/add/{id}', [FriendshipController::class, 'add'])->name('friends.add');
    Route::post('/friends/accept/{id}', [FriendshipController::class, 'accept'])->name('friends.accept');
    Route::post('/friends/reject/{id}', [FriendshipController::class, 'reject'])->name('friends.reject');
});

// Posts Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
});

// Comments Routes
Route::middleware(['auth'])->group(function () {
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
});

// Reactions
Route::middleware(['auth'])->group(function () {
    Route::post('/posts/{post}/react', [ReactionController::class, 'toggle'])->name('posts.react');
    Route::post('/comments/{comment}/react', [ReactionController::class, 'toggleComment'])->name('comments.react');
});

// Admin Moderation
Route::middleware(['auth'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index')->middleware('can:admin-access');
    // // Admin Moderation
    Route::post('/admin/posts/{post}/approve', [AdminController::class, 'approve'])->name('admin.approve');
    Route::post('/admin/posts/{post}/reject', [AdminController::class, 'reject'])->name('admin.reject');
});

// Invitations
Route::middleware(['auth'])->group(function () {
    Route::get('/invitations', [InvitationController::class, 'index'])->name('invitations.index');
    Route::post('/invitations', [InvitationController::class, 'store'])->name('invitations.store');
    Route::delete('/invitations/{invitation}', [InvitationController::class, 'destroy'])->name('invitations.destroy');
});

// Messagerie
Route::middleware(['auth'])->group(function () {
    Route::get('/messagerie', [MessagerieController::class, 'index'])->name('messagerie.index');
    Route::get('/messagerie/{user}', [MessagerieController::class, 'show'])->name('messagerie.show');
    Route::post('/messagerie/{user}', [MessagerieController::class, 'store'])->name('messagerie.store');
});

// Stories
Route::middleware(['auth'])->group(function () {
    Route::get('/stories', [StoryController::class, 'index'])->name('stories.index');
    Route::get('/stories/create', [StoryController::class, 'create'])->name('stories.create');
    Route::post('/stories', [StoryController::class, 'store'])->name('stories.store');
    Route::delete('/stories/{story}', [StoryController::class, 'destroy'])->name('stories.destroy');
});

// Users
Route::middleware(['auth'])->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
});


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

// Route::get('/qrcode', function(){
//     return QrCode::size(200)->generate('Hello Mehdi!');
// });


Route::get('/qrcode', fn() => QrCode::size(200)->generate('Hello Mehdi!'));


Route::get('/my_qr', [QrController::class, 'myQr'])->middleware('auth');
require __DIR__ . '/auth.php';
