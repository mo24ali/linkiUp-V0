<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
// use Illuminate\Container\Attributes\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ProfileController extends Controller
{

    public function show(int $id): View
    {
        $user = User::with([
            'posts.user',
            'posts.comments.user',
            'posts.likes',
            'profile'
        ])->findOrFail($id);

        return view('profile.show', compact('user'));
    }


    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $data = $request->validated();
        $data['auto_delete_enabled'] = $request->boolean('auto_delete_enabled');

        $user->fill($data);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        if ($request->has('bio') || $request->hasFile('avatar')) {
            $profileData = [];
            if ($request->has('bio')) {
                $profileData['bio'] = $request->bio;
            }
            if ($request->hasFile('avatar')) {
                if ($user->profile && $user->profile->avatar) {
                    Storage::disk('public')->delete($user->profile->avatar);
                }
                $profileData['avatar'] = $request->file('avatar')->store('avatars', 'public');
            }
            $user->profile()->updateOrCreate(['user_id' => $user->id], $profileData);
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
