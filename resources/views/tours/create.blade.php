@extends('layout.masterdash')
@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
          Tours
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('tours.store') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Nombre Tour:</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Precio Venta:</label>
                    <input type="number" name="price" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Precio Venta Mínimo:</label>
                    <input type="number" name="min_price" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Costo:</label>
                    <input type="number" name="cost" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Precio Venta Infante:</label>
                    <input type="number" name="child_price" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Costo Infante:</label>
                    <input type="number" name="child_cost" class="form-control" required>
                </div>
                <span>*Dato requerido, si no tiene valor ingrese 0 (ciero).</span><br>
                <button type="submit" class="btn btn-primary mt-3">Criar Tour</button>
            </form>
        </div>
    </div>
</div>
@endsection
