@extends('layout.masterdash')
    @section('content')
        @livewire('vincular-veiculos', ['grupos' => $grupos])
    @endsection
@section('script')
@endsection