<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Api\ApiController;

class LoginApiController extends ApiController
{
    public function login(Request $request){

        $email = $request->get('email');
        $password = $request->get('password');

        $queryUser = User::where('email', $email)->first();
        if (empty($queryUser)) {
            return $this->sendError('Invalid credentials', 400);
        }

        if (!Hash::check($password, $queryUser->password)) {
            return $this->sendError('Invalid credentials', 400);
        }

        $token = $queryUser->createToken($queryUser->email);
        return $this->sendSuccess(
            ['token' => $token->plainTextToken],
            'Login success'
        );
    }
}
