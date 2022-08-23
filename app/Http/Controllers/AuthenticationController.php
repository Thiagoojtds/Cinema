<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    public function logIn(Request $req)
    {   
       $data = $req->validate([
        'email' => ['required', 'email'],
        'password' => ['required']
       ]);

       if (!Auth::attempt($data)) {

            return back()->withErrors(['E-mail ou senha inválido']);
        } 

       $req->session()->regenerate();

       return redirect()->intended('/admin');
    }

    public function logout(Request $req)
    {   
        Auth::logout();

        $req->session()->invalidate();

        $req->session()->regenerateToken();

        return redirect('/');
    }
}
