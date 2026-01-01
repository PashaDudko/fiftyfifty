<?php

namespace App\Http\Controllers\Auth\Google;

use App\Events\UserRegisteredThroughGoogle;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();
        $user = User::where('email', $googleUser->email)->first();

        if (!$user) {
            $password = 'password'; //Str::random(8);
            $user = User::create([
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'password' => \Hash::make($password),
                'remember_token' => Str::random(10),
            ]);

            UserRegisteredThroughGoogle::dispatch($user, $password);
        }

        Auth::login($user);

        return redirect()->intended(route('dashboard', absolute: false));
    }
}
