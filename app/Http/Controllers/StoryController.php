<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StoryController extends Controller
{


    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:10240', // 10MB max
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('stories', 'public');

            \App\Models\Story::create([
                'user_id' => auth()->id(),
                'image_path' => $path,
            ]);
        }

        return back()->with('success', 'Story posted!');
    }
}
