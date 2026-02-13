<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Request;

class AdminController extends Controller
{
   

    public function index()
    {
<<<<<<< HEAD

   

       $pendingPosts = Post::where('status', 'pending')->latest()->get();
=======
        $pendingPosts = Post::where('status', 'pending')->latest()->get();
>>>>>>> 3eb72ef463e64be5c52cb1e34670dd12a44634f5
        $flaggedPosts = Post::where('status', 'flagged')->latest()->get();

        return view('admin.index', compact('pendingPosts', 'flaggedPosts'));
    }

    public function approve(Post $post)
    {
<<<<<<< HEAD
                 $this->authorize('admin-acces');

=======
>>>>>>> 3eb72ef463e64be5c52cb1e34670dd12a44634f5
        $post->update(['status' => 'published']);
        return back()->with('success', 'Post approved.');
    }

    public function reject(Post $post)
    {
        $post->delete();
        return back()->with('success', 'Post rejected and deleted.');
    }
<<<<<<< HEAD

    // private function authorizeAdmin()
    // {
    //     if (!auth()->user()->is_admin) {
    //         abort(403, 'Unauthorized action.');
    //     }
    // }
=======
>>>>>>> 3eb72ef463e64be5c52cb1e34670dd12a44634f5
}
