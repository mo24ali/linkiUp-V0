<?php

namespace App\Http\Controllers;

use Faker\Guesser\Name;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {

        return view('findFriends.index');
    }
    public function show()
    {
        $user = DB::table('users')->where('name', 'test')->first();
        return view('profile.show', [
            'user' => $user
        ]);
    }
    
}
