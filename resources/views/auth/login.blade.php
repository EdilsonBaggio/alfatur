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
               <form method="POST" action="{{ route('login') }}">
                  @csrf 

                  <div class="form-group"> 
                     <div>
                        <input id="email" class="form-control @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email') }}" placeholder="Usuario" required autofocus> 
                     </div>
                     @error('email') 
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
                     <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="lembrar">
                        <label class="form-check-label" for="lembrar">
                          Lembrar-me
                        </label>
                     </div>
                     <a href="{{ route('esqueci-a-senha') }}">Esqueceu sua senha?</a>
                  </div>
                  <div class="mb-0 botoes-cadastro">
                     <button type="submit" class="btn btn-primary"> 
                        Log In
                     </button>
                  </div>
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
