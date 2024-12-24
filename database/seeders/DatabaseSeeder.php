<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Edilson',
            'email' => 'developer@symbster.com',
            'password' => Hash::make('mudar123!'), // Criptografando a senha
            'role' => 'Administrador',
            'rut' => '12345678901',
            'whatsapp' => '(99) 99999-9999',
            'commission_percentage' => 10.5,
        ]);
    }
}