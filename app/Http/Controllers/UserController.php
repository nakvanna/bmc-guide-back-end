<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $user = User::all();
        return $user;
    }

    public function login(Request $request){
        $loginData = $request->validate([
            'email'=>'required',
            'password'=>'required',
        ]);
        if (!auth()->attempt($loginData)){
            return response()->json(['message'=>'Invalid Credentials']);
        }
        $accessToken = auth()->user()->createToken('authToken')->accessToken;
        return response()->json(['user'=>auth()->user(),'access_token'=>$accessToken]);
    }
}
