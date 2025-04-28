<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirectGoogle()
    {

        return Socialite::driver('google')->redirect();

    }

    public function googleCallback(Request $request)
    {

        $googleUser = Socialite::driver('google')->user();
        $finder = User::where('google_id', $googleUser->getId())->first();
        if ($finder) {
            // User already exists, log them in
            Auth::login($finder);
            return redirect()->intended('dashboard');
        }else{
            $user = User::updateOrCreate([
                'email' => $googleUser->getEmail(),
            ], [
                'name' => $googleUser->getName(),
                'google_id' => $googleUser->getId(),
                'password' => encrypt('123456789'), // Generate a random password
            ]);

            Auth::login($user);

            return response()->json([
                'message' => 'User created successfully',
                'user' => $user,
            ]);
        }



    }
}
