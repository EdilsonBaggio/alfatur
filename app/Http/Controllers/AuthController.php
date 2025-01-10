<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Verifica se o usuário já está logado
        if (Auth::guard('web')->check()) {
            return redirect()->route('home');
        }

        $credentials = $request->only('email', 'password');

        // Tenta autenticar o usuário
        if (Auth::guard('web')->attempt($credentials)) {
            return redirect()->intended('home');
        }

        return back()->withErrors(['email' => 'Os dados estão incorretos ou não existe usuário cadastrado.'])->withInput($request->only('email'));
    }

    public function logout()
    {
        Auth::logout();
        session()->invalidate(); 
        session()->regenerateToken();
        return redirect('/');
    }

}
