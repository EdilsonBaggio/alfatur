@extends('layout.masterdash')

@section('content')
<div class="content-tabelas content-estimativo">
    <div class="container">
        <div class="card">
            <div class="card-header">
              Estimativo
            </div>
            <div class="card-body">
              <!-- Formulário de filtro por data -->
              <form method="GET" action="{{ route('estimativo.index') }}">
                <div class="form-group">
                    <label for="filterDate">Filtrar por Data:</label>
                    <input type="date" id="filterDate" name="filterDate" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Filtrar</button>
            </form>
            
            <div class="row estimativo mt-4">
                @foreach($groupedTours as $date => $tours)
                    @if (!request('filterDate') || request('filterDate') === $date) 
                    <div class="col-md-4">
                      <div class="day-group">
                          <h5>{{ Carbon\Carbon::parse($date)->format('l') }} <br> <div class="date"><i class="bi bi-calendar3"></i> {{ Carbon\Carbon::parse($date)->format('d-m-Y') }}</div></h5> 
                          <ul>
                              @foreach($tours as $tour)
                                  <li class="d-flex">
                                    <div class="id_tour">{{ $tour->id }}</div>
                                    <div>
                                      {{ $tour->tour }}
                                    </div>
                                  </li>
                              @endforeach
                          </ul>
                      </div>
                    </div>
                    @endif
                @endforeach
            </div>
            
            </div>
        </div>       
    </div>
</div>
@endsection

@section('script')
@endsection
