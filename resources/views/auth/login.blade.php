@extends('layout.master') 
<style>
   .alert-danger {
    color: #ffffff!important;
    background-color: #f8d7da!important;;
    border-color: #f5c6cb!important;;
    font-size: 13px!important;;
    background: transparent!important;;
    padding: 0!important;;
    border: 0!important;;
}
</style>

@section('content')
<div class="container content-login"> 
   <div class="row justify-content-center"> 
      <div class="col-md-7"> 
         <div class="col text-center content-logo">
            <img  class="img-fluid" src="{{ Vite::asset('resources/images/logo.svg') }}" alt="">
         </div>
         <div class="card"> 
            <div class="card-body contant-login-form">
               @if ($errors->any())
                  <div class="alert alert-danger">
                     @foreach ($errors->all() as $error)
                           <div s>{{ $error }}</div>
                     @endforeach
                  </div>
               @endif
               <form method="POST" action="{{ route('login') }}">
                  @csrf 

                  <div class="form-group"> 
                     <div>
                        <input id="name" class="form-control @error('name') is-invalid @enderror" type="name" name="name" value="{{ old('name') }}" placeholder="Usuario" required autofocus> 
                     </div>
                     @error('name') 
                        <span class="invalid-feedback" role="alert"> 
                           <strong>{{ $message }}</strong> 
                        </span>
                     @enderror 
                  </div>
                  <br>
                  <div class="form-group">
                     <div>
                        <input id="password" class="form-control @error('password') is-invalid @enderror" type="password" name="password" placeholder="Contraseña" required>
                     </div>
                     @error('password')
                        <span class="invalid-feedback" role="alert">
                           <strong>{{ $message }}</strong>
                        </span>
                     @enderror
                  </div>
                  <div class="content-login-esqueci">
                     <a href="{{ route('esqueci-a-senha') }}">¿Olvidaste tu contraseña?</a>
                  </div>
                  <div class="mb-0 botoes-cadastro">
                     <button type="submit" class="btn btn-primary"> 
                        Entrar
                     </button>
                  </div>
                  <img class="img-fluid mt-3" src="{{ Vite::asset('resources/images/mountain.png') }}" alt="">
                  <i class="derechos">ALFATUR Chile - Todos los Derechos Reservados</i>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@section('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
