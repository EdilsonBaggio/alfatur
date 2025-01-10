<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'rut',
        'whatsapp',
        'commission_percentage',
        'permissions', // Adicionando o campo de permissões
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'verificacao_email' => 'datetime',
        'password' => 'hashed',
        'permissions' => 'array', // Cast para tratar permissões como array
    ];

    /**
     * Verifica se o usuário tem uma permissão específica.
     *
     * @param string $permission
     * @return bool
     */
    public function hasPermission($permission)
    {
        // Administradores têm acesso a tudo
        if ($this->role === 'Administrador') {
            return true;
        }

        // Verifica se a permissão existe na lista de permissões do usuário
        $permissions = $this->permissions ?? [];
        return in_array($permission, $permissions);
    }
}
