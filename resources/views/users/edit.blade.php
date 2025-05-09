@extends('layout.masterdash')

@section('content')
<div class="container content-edit">
    <div class="card">
        <div class="card-header">
            Editar Usuário
        </div>
        <div class="card-body">
            <form action="{{ route('users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>Nome</label>
                    <input type="text" name="name" value="{{ $user->name }}" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ $user->email }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Senha:</label>
                    <input type="password" id="password" name="password" value="{{ $user->email }}" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Nível</label>
                    <select name="role" class="form-control" required>
                        <option value="Administrador" {{ $user->role == 'Administrador' ? 'selected' : '' }}>Administrador</option>
                        <option value="SuperVendedor" {{ $user->role == 'SuperVendedor' ? 'selected' : '' }}>SuperVendedor</option>
                        <option value="Vendedor" {{ $user->role == 'Vendedor' ? 'selected' : '' }}>Vendedor</option>
                        <option value="Guia" {{ $user->role == 'Guia' ? 'selected' : '' }}>Guia</option>
                        <option value="Condutor" {{ $user->role == 'Condutor' ? 'selected' : '' }}>Condutor</option>
                        <option value="Logística" {{ $user->role == 'Logística' ? 'selected' : '' }}>Logística</option>
                        <option value="Agencia Externa" {{ $user->role == 'Agencia Externa' ? 'selected' : '' }}>Agencia Externa</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>RUT</label>
                    <input id="rut" type="text" name="rut" value="{{ $user->rut }}" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Whatsapp</label>
                    <input id="whatsapp" type="text" name="whatsapp" value="{{ $user->whatsapp }}" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Porcentagem Comissão (%)</label>
                    <input type="text" name="commission_percentage" value="{{ number_format($user->commission_percentage, 0, ',', '.') }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="permissions" class="form-label">Permissões de Acesso</label>
                    @php
                        // Mapeamento das permissões para os valores visíveis no formulário
                        $permissionsMapping = [
                            'Mi conta' => 'home',
                            'Usuarios' => 'usuarios.create',
                            'Viajes/Vendedor' => 'viajes.vendedor',
                            'Logística' => 'logistica.index',
                            'Realizadas Por Pagar' => 'realizadas.pagar',
                            'Viajes FULL' => 'viajes.full',
                            'Pagos FULL' => 'pagos.full',
                            'Vender' => 'vendas.create',
                            'Mis Vendas' => 'vendas.list',
                            // 'Confirmados' => 'confirmados',
                            'Estimativo' => 'estimativo.index',
                            'Tours' => 'tours.create',
                            // 'Mis Liquidaciones' => 'mis.liquidaciones',
                            // 'Liquidaciones' => 'liquidaciones'
                        ];
                
                        $userPermissions = $user->permissions ?? []; // Obtém as permissões do banco
                    @endphp
                
                    @foreach ($permissionsMapping as $key => $value)
                        <div class="form-check">
                            <input 
                                class="form-check-input" 
                                type="checkbox" 
                                name="permissions[]" 
                                value="{{ $value }}" 
                                id="{{ str_replace(' ', '_', strtolower($key)) }}" 
                                {{ in_array($value, $userPermissions) ? 'checked' : '' }}
                            >
                            <label class="form-check-label" for="{{ str_replace(' ', '_', strtolower($key)) }}">{{ $key }}</label>
                        </div>
                    @endforeach
                </div>
                            

                <button type="submit" class="btn btn-primary">Salvar</button>
                <a href="{{ route('users.list') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function(){
        $('#rut').mask('00.000.000-0', {reverse: true});
        $('#whatsapp').mask('+00 90000-0000');
        $('#commission_percentage').mask('00');
    });
</script>
@endsection