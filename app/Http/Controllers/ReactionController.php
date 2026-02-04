<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Post;
class ReactionController extends Controller
{
    public function toggle(Post $post)
    {
        $user = Auth::user();
        // dd($user);
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
