<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $this->authorizeAdmin();
        $pendingPosts = Post::where('status', 'pending')->latest()->get();
        $flaggedPosts = Post::where('status', 'flagged')->latest()->get();

        return view('admin.index', compact('pendingPosts', 'flaggedPosts'));
    }

    public function approve(Post $post)
    {
        $this->authorizeAdmin();
        $post->update(['status' => 'published']);
        return back()->with('success', 'Post approved.');
    }

    public function reject(Post $post)
    {
        $this->authorizeAdmin();
        $post->delete();
        return back()->with('success', 'Post rejected and deleted.');
    }

    private function authorizeAdmin()
    {
        if (!auth()->user()->is_admin) {
            abort(403, 'Unauthorized action.');
        }
    }
}
