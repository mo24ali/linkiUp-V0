<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;

class GenerateInviteController extends Controller
{
    public function generateInvite()
    {
        $user = auth()->user();

        // lien temporaire pour 1h
        $link = URL::temporarySignedRoute(
            'friend.accept',
            now()->addHour(),
            ['slug' => $user->slug] // le slug de l'utilisateur
        );

        return view('profile.show', compact('link','user'));
    }
}
