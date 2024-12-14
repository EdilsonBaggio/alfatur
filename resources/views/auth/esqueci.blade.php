@extends('layout.master')

@section('content')
<div class="container content-login">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="col text-center content-logo">
                <img  class="img-fluid" src="{{ Vite::asset('resources/images/logo.svg') }}" alt="">
            </div>
            <div class="card">
                <div class="card-body contant-login-form">
                    @if (session('message'))
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    @endif
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="form-group">
                            <div>
                                <input id="email" class="form-control @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email') }}" placeholder="E-mail" required autofocus>
                            </div>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="mt-3 botoes-cadastro">
                            <button type="submit" class="btn btn-primary">
                                Enviar e-mail
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

