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
                    <label class="form-label">Nome Tour:</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Preço Venda:</label>
                    <input type="number" name="price" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Preço Venda Mínimo:</label>
                    <input type="number" name="min_price" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Custo:</label>
                    <input type="number" name="cost" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Preço Infantil:</label>
                    <input type="number" name="child_price" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Custo Infantil:</label>
                    <input type="number" name="child_cost" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Criar Tour</button>
            </form>
        </div>
    </div>
</div>
@endsection
