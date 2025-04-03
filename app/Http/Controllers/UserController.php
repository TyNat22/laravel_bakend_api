<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        $users = User::get();
        return view('admin.user.index',compact('users'));
    }
    public function create(){
        return view('auth.register');
    }
    public function destroy($id){
        $users = User::find($id);

        if($users){
            $users->delete();
            return redirect()->route('admin.user');
        }
    }

}
