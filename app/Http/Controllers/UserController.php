<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|string',
            'rut' => 'required|string|max:20|unique:users',
            'whatsapp' => 'required|string|max:20',
            'commission_percentage' => 'nullable|numeric|min:0|max:100',
        ]);

        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role' => $request->input('role'),
            'rut' => $request->input('rut'),
            'whatsapp' => $request->input('whatsapp'),
            'commission_percentage' => $request->input('commission_percentage'),
        ]);

        return redirect()->back()->with('success', 'Usuário criado com sucesso!');
    }
}
