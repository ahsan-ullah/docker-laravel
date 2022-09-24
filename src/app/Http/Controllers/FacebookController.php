<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class FacebookController extends Controller
{
    public function provider()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleCallback()
    {
        $user = Socialite::driver('facebook')->user();
        return $user;
    }
}
