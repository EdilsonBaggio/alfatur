@extends('layout.masterdash')
@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
          Editar Tour
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('tours.update', $tour->id) }}">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Nombre Tour:</label>
                    <input type="text" name="name" class="form-control" value="{{ $tour->name }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Precio Venta:</label>
                    <input type="text" name="price" class="form-control" value="{{ number_format($tour->price, 0, ',', '.') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Precio Venta Mínimo:</label>
                    <input type="text" name="min_price" class="form-control" value="{{ number_format($tour->min_price, 0, ',', '.') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Costo:</label>
                    <input type="text" name="cost" class="form-control" value="{{ number_format($tour->cost, 0, ',', '.') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Precio Venta Infante:</label>
                    <input type="text" name="child_price" class="form-control" value="{{ number_format($tour->child_price, 0, ',', '.') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Costo Infante:</label>
                    <input type="text" name="child_cost" class="form-control" value="{{ number_format($tour->child_cost, 0, ',', '.') }}" required>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" name="status" class="form-check-input" value="1" {{ $tour->status ? 'checked' : '' }}>
                    <label class="form-check-label">Desativar Status</label>
                </div>
                <span>*Dato requerido, si no tiene valor ingrese 0 (ciero).</span><br>
                <button type="submit" class="btn btn-primary mt-3">Atualizar Tour</button>
            </form>
        </div>
    </div>
</div>
@endsection
