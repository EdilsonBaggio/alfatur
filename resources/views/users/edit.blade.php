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
                    <input type="number" name="commission_percentage" value="{{ $user->commission_percentage }}" class="form-control">
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
    });
</script>
@endsection