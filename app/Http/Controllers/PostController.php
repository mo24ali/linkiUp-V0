<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\Story;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
class PostController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        // Use optimized friend IDs helper
        $friendIds = User::all()->pluck('id');
        
        $friendIds[] = $user->id;

        $query = Post::where('status', 'published');

        if ($request->filled('search')) {
            $query->where('content', 'like', '%' . $request->search . '%');
        } else {
            // Show feed from friends and self
            $query->whereIn('owner_id', $friendIds);
        }

        $posts = Post::all();

        if ($request->ajax()) {
            return view('components.post-list', compact('posts'))->render();
        }

        // Cache stories for 5 minutes
        $stories = Cache::remember('active_stories', 300, function () {
            return Story::where('created_at', '>=', now()->subDay())
                ->with('user.profile')
                ->latest()
                ->get();
        });

        // Suggestions for "Who to follow": users who are not friends yet
        $suggestions = User::where('id', '!=', $user->id)
            ->whereNotIn('id', $friendIds)
            ->with('profile')
            ->inRandomOrder()
            ->limit(5)
            ->get();

        return view('dashboard', compact('posts', 'stories', 'suggestions'));
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
                $status = 'pending';
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
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return back()->with('success', 'Post deleted successfully!');
    }
}
