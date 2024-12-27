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

    public function lista()
    {
        // Buscar todos os usuários
        $users = User::all();
    
        // Passar os usuários para a view
        return view('users.list', compact('users'));
    }   


    public function edit($id)
    {
        $user = User::findOrFail($id); // Busca o usuário pelo ID
        return view('users.edit', compact('user')); // Carrega a view para edição
    }

    
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Validação dos dados
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'role' => 'required|string',
            'rut' => 'required|string|max:20|unique:users,rut,' . $id,
            'whatsapp' => 'required|string|max:20',
            'commission_percentage' => 'nullable|numeric|min:0|max:100',
        ]);

        // Atualiza os dados
        $user->update($request->all());

        return redirect()->route('users.list')->with('success', 'Usuário atualizado com sucesso!');
    }
}
