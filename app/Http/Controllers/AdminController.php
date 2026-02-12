<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class AdminController extends Controller
{
   

    public function index()
    {
        $pendingPosts = Post::where('status', 'pending')->latest()->get();
        $flaggedPosts = Post::where('status', 'flagged')->latest()->get();

        return view('admin.index', compact('pendingPosts', 'flaggedPosts'));
    }

    public function approve(Post $post)
    {
        $post->update(['status' => 'published']);
        return back()->with('success', 'Post approved.');
    }

    public function reject(Post $post)
    {
        $post->delete();
        return back()->with('success', 'Post rejected and deleted.');
    }
}
