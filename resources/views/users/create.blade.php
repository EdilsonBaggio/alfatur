@extends('layout.masterdash')

@section('content')
<div class="container content-cadastro">
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

        <!-- Botão Criar -->
        <button type="submit" class="btn btn-outline-primary">Crear Usuário</button>
        <a class="btn btn-outline-secondary" href="{{ route('users.list') }}">Ver lista de usuarios</a>
    </form>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function(){
        $('#rut').mask('00.000.000-0', {reverse: true});
        $('#whatsapp').mask('+00 90000-0000');
    });
</script>
@endsection