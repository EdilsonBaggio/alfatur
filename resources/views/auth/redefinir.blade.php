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
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group d-none">
                            <div>
                                <span>E-mail</span>
                                <input id="email" class="form-control @error('email') is-invalid @enderror" type="email" name="email" value="{{ $email ?? old('email') }}" required autofocus>
                            </div>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <div>
                                <input id="password" class="form-control @error('password') is-invalid @enderror" type="password" name="password" placeholder="Nova senha" required>
                            </div>
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group mt-3">
                            <div>
                                <input id="password-confirm" class="form-control" type="password" name="password_confirmation" placeholder="Confirmar senha" required>
                            </div>
                        </div>

                        <div class="mt-3 botoes-cadastro">
                            <button type="submit" class="btn btn-primary">
                                Redefinir senha
                            </button>
                        </div>
                        <div class="link-esqueci">
                            <p>Lembrou sua senha? <a href="{{ route('login') }}"> Faça login</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
