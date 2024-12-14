@extends('layout.master')

@section('content')
<div class="container content-login">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="col text-center content-logo">
                <h1>Esqueceu sua senha?</h1>
                <p>Digite seu e-mail e as instruções serão enviadas para você</p>
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
                            <label for="email">
                                 <svg xmlns="http://www.w3.org/2000/svg" width="16" height="14" viewBox="0 0 16 14" fill="none">
                                    <path d="M12.909 0.924988H2.278C1.67384 0.924988 1.09442 1.16499 0.667211 1.5922C0.240003 2.01941 0 2.59882 0 3.20299V10.797C0 11.4012 0.240003 11.9806 0.667211 12.4078C1.09442 12.835 1.67384 13.075 2.278 13.075H12.909C13.5132 13.075 14.0926 12.835 14.5198 12.4078C14.947 11.9806 15.187 11.4012 15.187 10.797V3.20299C15.187 2.59882 14.947 2.01941 14.5198 1.5922C14.0926 1.16499 13.5132 0.924988 12.909 0.924988ZM12.6 2.44399L8.133 6.90899C8.06244 6.98016 7.97848 7.03665 7.88597 7.07521C7.79345 7.11376 7.69422 7.13361 7.594 7.13361C7.49378 7.13361 7.39455 7.11376 7.30203 7.07521C7.20952 7.03665 7.12556 6.98016 7.055 6.90899L2.589 2.44399H12.6ZM13.671 10.797C13.671 10.9983 13.591 11.1913 13.4487 11.3337C13.3064 11.476 13.1133 11.556 12.912 11.556H2.278C2.0767 11.556 1.88365 11.476 1.74131 11.3337C1.59897 11.1913 1.519 10.9983 1.519 10.797V3.51399L5.984 7.97899C6.41114 8.40571 6.99022 8.64541 7.594 8.64541C8.19778 8.64541 8.77686 8.40571 9.204 7.97899L13.669 3.51399L13.671 10.797Z" fill="#959396"/>
                                 </svg>
                            </label>
                            <div>
                                <span>E-mail</span>
                                <input id="email" class="form-control @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email') }}" required autofocus>
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

