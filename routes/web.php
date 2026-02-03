<?php

use App\Http\Controllers\MessagerieController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FriendshipController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $currentUserId = Auth::id();
    $users = DB::table('users')->where('id', '!=', $currentUserId)->get();
    $posts = DB::table('posts')->get();
    return view('dashboard', [
        'users' => $users,
        'posts'=> $posts
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
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

Route::get('/messagerie/index',[MessagerieController::class , 'show']);


require __DIR__ . '/auth.php';
