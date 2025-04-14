@extends('layout.masterdash')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
          Cadastrar usuarios
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card-body">
            <form method="POST" action="{{ route('usuarios.store') }}">
                @csrf
                
                <!-- Nível -->
                <div class="mb-3">
                    <label for="role" class="form-label">Nível</label>
                    <select id="role" name="role" class="form-select" required>
                        <option value="Administrador">Administrador</option>
                        <option value="SuperVendedor">SuperVendedor</option>
                        <option value="Vendedor">Vendedor</option>
                        <option value="Guia">Guia</option>
                        <option value="Condutor">Condutor</option>
                        <option value="Logística">Logística</option>
                        <option value="Agencia Externa">Agencia Externa</option>
                    </select>
                </div>
        
                <!-- Nome e Sobrenome -->
                <div class="mb-3">
                    <label for="name" class="form-label">Nome e Sobrenome</label>
                    <input type="text" id="name" name="name" class="form-control" required>
                </div>
        
                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
        
                <!-- Senha -->
                <div class="mb-3">
                    <label for="password" class="form-label">Senha:</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>
        
                <!-- RUT -->
                <div class="mb-3">
                    <label for="rut" class="form-label">RUT</label>
                    <input type="text" id="rut" name="rut" class="form-control" required>
                </div>
        
                <!-- WhatsApp -->
                <div class="mb-3">
                    <label for="whatsapp" class="form-label">WhatsApp</label>
                    <input type="text" id="whatsapp" name="whatsapp" class="form-control" required>
                </div>
        
                <!-- Porcentagem Comissão -->
                <div class="mb-3">
                    <label for="commission_percentage" class="form-label">Porcentagem Comissão (%)</label>
                    <input type="number" id="commission_percentage" name="commission_percentage" class="form-control" min="0" max="100">
                </div>

                <!-- Permissões -->
                <div class="mb-3">
                    <label for="permissions" class="form-label">Permissões de Acesso</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="permissions[]" value="Mi conta" id="mi_conta">
                        <label class="form-check-label" for="mi_conta">Mi conta</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="permissions[]" value="Usuarios" id="usuarios">
                        <label class="form-check-label" for="usuarios">Usuarios</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="permissions[]" value="Viajes/Vendedor" id="viajes">
                        <label class="form-check-label" for="viajes">Viajes/Vendedor</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="permissions[]" value="Logística" id="logistica">
                        <label class="form-check-label" for="logistica">Logística</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="permissions[]" value="Realizadas Por Pagar" id="realizadas_por_pagar">
                        <label class="form-check-label" for="realizadas_por_pagar">Realizadas Por Pagar</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="permissions[]" value="Viajes FULL" id="viajes_full">
                        <label class="form-check-label" for="viajes_full">Viajes FULL</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="permissions[]" value="Pagos FULL" id="pagos_full">
                        <label class="form-check-label" for="pagos_full">Pagos FULL</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="permissions[]" value="Vender" id="vender">
                        <label class="form-check-label" for="vender">Vender</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="permissions[]" value="Mis Vendas" id="mis_vendas">
                        <label class="form-check-label" for="mis_vendas">Mis Vendas</label>
                    </div>
                    {{-- <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="permissions[]" value="Confirmados" id="confirmados">
                        <label class="form-check-label" for="confirmados">Confirmados</label>
                    </div> --}}
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="permissions[]" value="Estimativo" id="estimativo">
                        <label class="form-check-label" for="estimativo">Estimativo</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="permissions[]" value="Tours" id="tours">
                        <label class="form-check-label" for="tours">Tours</label>
                    </div>
                    {{-- <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="permissions[]" value="Mis Liquidaciones" id="mis_liquidaciones">
                        <label class="form-check-label" for="mis_liquidaciones">Mis Liquidaciones</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="permissions[]" value="Liquidaciones" id="liquidaciones">
                        <label class="form-check-label" for="liquidaciones">Liquidaciones</label>
                    </div> --}}
                </div>

        
                <!-- Botão Criar -->
                <button type="submit" class="btn btn-outline-primary">Crear Usuário</button>
                <a class="btn btn-outline-secondary" href="{{ route('users.list') }}">Ver lista de usuarios</a>
            </form>
        </div>
    </div>          
</div>
@endsection
@section('script')
<script>
    $(document).ready(function(){
        $('#rut').mask('00.000.000-0', {reverse: true});
        $('#whatsapp').mask('+00 00900000000');
    });
</script>
@endsection