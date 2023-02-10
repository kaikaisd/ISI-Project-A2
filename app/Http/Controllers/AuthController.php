<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class AuthController extends Controller
{
    public function login(Request $request){
        $credentials = $request->only('email', 'password');
        if (auth()->attempt($credentials)) {
            $token = Auth::user()->createToken('authToken')->accessToken;
            return response(['user' => auth()->user(), 'access_token' => $token]);
        }
        return response(['message' => 'Invalid Credentials']);
    }

    public function signup(){
        
    }
}
