<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class FacebookController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function callback()
    {
        $facebookUser = Socialite::driver('facebook')->user();

        $user = User::query()->firstOrCreate(
            ['email' => $facebookUser->getEmail()],
            [
                'name' => $facebookUser->getName() ?? 'User',
                'password' => bcrypt(Str::random(32)),
            ]
        );

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
