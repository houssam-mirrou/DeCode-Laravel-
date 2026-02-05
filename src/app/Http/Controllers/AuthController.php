<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function log_in(){
        return view('Pages.LogIn');
    }

    public function submit_login(Request $request){
        $request->validate([
            'email'=>'required|email|string|max:255',
            'password'=>'required|string|min:8'
        ]);
        if(Auth::attempt($request->only('email','password'))){
            return redirect()->route('home')->with('sucsses','Login successful.');
        }
        return redirect()->route('login')->with('failed','Login failed.')->onlyInput('email')->withErrors([
            'email'=>'Email or password is invalide.'
        ]);
    }

    public function log_out(){
        Auth::logout();
        return redirect()->route('home')->with('sucsses','You have been logged out.');
    }

}
