<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{

    public function showLoginForm()
    {
        return view('auth.login');
    }
    public function showRegisterForm()
    {
        return view('auth.register');
    }
    public function login(Request $request)
    {
        // Retrieve email and password from the request
        $email = $request->get('email');
        $password = $request->get('password');

        // Attempt to find the user by email
        $queryUser = User::where('email', $email)->first();

        // If no user is found, redirect back with an error
        if (empty($queryUser)) {
            return redirect()->back()->with(['error' => 'Invalid credentials.']);
        }

        // Check if the provided password matches the stored hash
        if (!Hash::check($password, $queryUser->password)) {
            return redirect()->back()->withErrors(['password' => 'Invalid credentials.']);
        }

        // Compare the user's role (only allow access if the role is 'admin')
        if ($queryUser->role !== 'admin') {
            return redirect()->back()->with(['error' => 'You Are Not Allow for Login in this!'], 401);

        }else{

            Auth::login($queryUser);
            return redirect()->route('admin.dashboard')->with('login_success', 'Login successful!');;
        }


    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }





    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
}
