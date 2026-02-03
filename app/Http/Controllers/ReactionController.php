<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Post;
use App\Models\Reaction;

class ReactionController extends Controller
{
    public function toggle(Post $post)
    {
        $user = auth()->user();
        $reaction = $post->reactions()->where('user_id', $user->id)->first();

        if ($reaction) {
            $reaction->delete();
            return back()->with('success', 'Like removed.');
        } else {
            $post->reactions()->create([
                'user_id' => $user->id,
                'type' => 'like',
            ]);
            return back()->with('success', 'Post liked!');
        }
    }
}
