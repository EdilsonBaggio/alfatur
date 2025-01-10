<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Criando um usuário administrador com todas as permissões
        \App\Models\User::factory()->create([
            'name' => 'Edilson',
            'email' => 'developer@symbster.com',
            'password' => Hash::make('mudar123!'), // Criptografando a senha
            'role' => 'Administrador',
            'rut' => '12345678901',
            'whatsapp' => '(99) 99999-9999',
            'commission_percentage' => 10.5,
            'permissions' => [
                'home',
                'usuarios.create',
                'viajes.vendedor',
                'logistica.index',
                'realizadas.pagar',
                'viajes.full',
                'pagos.full',
                'vendas.create',
                'vendas.list',
                'confirmados',
                'estimativo.index',
                'tours.create',
                'mis.liquidaciones',
                'liquidaciones',
            ],
        ]);
    }
}
