<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $friendIds = $user->acceptedFriends()->pluck('id')->toArray();
        $friendIds[] = $user->id;

        $posts = Post::whereIn('owner_id', $friendIds)
            ->where('status', 'published')
            ->with(['user', 'comments.user', 'likes'])
            ->latest()
            ->paginate(10);

        return view('dashboard', compact('posts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $status = 'published';
        $forbiddenWords = ['badword1', 'badword2', 'spam', 'hate'];

        foreach ($forbiddenWords as $word) {
            if (stripos($request->content, $word) !== false) {
                $status = 'pending'; // For moderation
                break;
            }
        }

        $postData = [
            'content' => $request->content,
            'owner_id' => auth()->id(),
            'status' => $status,
        ];

        if ($request->hasFile('image')) {
            $postData['image'] = $request->file('image')->store('posts', 'public');
        }

        Post::create($postData);

        $msg = $status === 'pending'
            ? 'Your post is pending moderation due to its content.'
            : 'Post created successfully!';

        return back()->with('success', $msg);
    }

    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $request->validate([
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $post->content = $request->content;

        if ($request->hasFile('image')) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $post->image = $request->file('image')->store('posts', 'public');
        }

        $post->save();

        return back()->with('success', 'Post updated successfully!');
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return back()->with('success', 'Post deleted successfully!');
    }
}
