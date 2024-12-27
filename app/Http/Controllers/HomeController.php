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
        $users = User::findOrFail($id);

        // Upload do arquivo
        if ($request->hasFile('photo')) {
            // Deleta a foto antiga, se existir
            if ($users->photo) {
                Storage::delete($users->photo);
            }

            // Salva a nova foto
            $imagePath = $request->file('photo')->store('photos', 'public');
            $imageUrl = asset('storage/' . $imagePath);
            $users->photo = $imageUrl;
            $users->save();
        }

        return back()->with('success', 'Foto atualizada com sucesso!');
    }

}
