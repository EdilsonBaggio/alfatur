<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * Exibe a página inicial (home).
     */
    public function index()
    {
        return view('home'); // Retorna a view home.blade.php
    }

    public function updatePhoto(Request $request, $id)
    {
        // Validação do arquivo
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Somente imagens com até 2MB
        ]);

        // Encontrar o usuário
        $user = User::findOrFail($id); // Corrigido para $user no singular

        // Upload do arquivo
        if ($request->hasFile('photo')) {
            // Deleta a foto antiga, se existir
            if ($user->photo) {
                Storage::delete($user->photo); // Mantido como $user
            }

            // Salva a nova foto
            $path = $request->file('photo')->move(
                public_path('uploads'),
                uniqid() . '.' . $request->file('photo')->getClientOriginalExtension()
            );

            // Salva no banco de dados apenas 'uploads/arquivo.png'
            $user->photo = 'uploads/' . basename($path);
            $user->save(); // Mantido como $user
        }

        return back()->with('success', 'Foto atualizada com sucesso!');
    }
}
