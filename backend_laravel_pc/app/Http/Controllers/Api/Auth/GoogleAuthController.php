<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class GoogleAuthController extends Controller
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

            $token = $user->createToken('google-token')->plainTextToken;

            return response()->json([
                'user' => $user,
                'token' => $token
            ]);
        }



    }
}
