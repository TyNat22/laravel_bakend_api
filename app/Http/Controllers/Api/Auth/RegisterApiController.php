<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Api\ApiController;

class RegisterApiController extends ApiController
{
    public function register(Request $request){

        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email'=> 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        // Check if the user already exists
        $existingUser = User::where('email', $request->email)->first();
        if ($existingUser) {
            return response()->json([
                'message' => 'User already exists'
            ], 400);
        }
        // Create a new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role ?? 'customer'
        ]);

        return $this->sendSuccess(
            ['user' => $user],
            'User registered successfully'
        );

    }
}
