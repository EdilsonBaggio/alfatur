<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {

        if (Auth::guard('web')->check()) {
            return redirect()->route('home');
        }
        
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Verifica se o usuário já está logado
        if (Auth::guard('web')->check()) {
            return redirect()->route('home');
        }
    
        $credentials = $request->only('name', 'password');
    
        // Tenta autenticar o usuário
        if (Auth::guard('web')->attempt($credentials)) {
            // Verifica se está ativo
            if (Auth::user()->is_active == 0) {
                Auth::logout();
                return back()->withErrors(['name' => 'Sua conta está desativada.'])->withInput($request->only('name'));
            }
    
            return redirect()->intended('home');
        }
    
        return back()->withErrors(['name' => 'Os dados estão incorretos ou não existe usuário cadastrado.'])->withInput($request->only('name'));
    }
    

    public function logout()
    {
        Auth::logout();
        session()->invalidate(); 
        session()->regenerateToken();
        return redirect('/');
    }

}
