@extends('layout.master') 
<style>
    h2 {
        line-height: 37px!important;
        color: #fff!important;
        text-transform: uppercase!important;
        font-weight: 800!important;
        font-size: 15px!important;
    }
    .form-group {
        margin-bottom: 15px;
        flex-direction: column;
    }
    input{
        text-align: center;
    }
    label {
        margin-right: 0px!important;
        font-size: 14px!important;
        font-weight: 600!important;
    }
</style>
@section('content')
<div class="container content-login"> 
   <div class="row justify-content-center"> 
      <div class="col-md-7"> 
         <div class="col text-center content-logo">
            <img  class="img-fluid" src="{{ Vite::asset('resources/images/logo.jpeg') }}" alt="">
         </div>
         <div class="card"> 
            <div class="card-body contant-login-form">
                <h2>Acesso ao Voucher</h2>

                @if(session('error'))
                    <p style="color: #c10000; margin-bottom: 12px;font-size: 14px;font-style: italic;">{{ session('error') }}</p>
                @endif
            
                <form method="POST" action="{{ route('voucher.login.submit') }}">
                    @csrf
                    <div class="form-group"> 
                        <label for="codigo">Código da Reserva:</label>
                        <input type="text" name="codigo" placeholder="ALF - 15111" required>
                     </div>
                     <br>
                     <div class="form-group">
                        <label for="nome">Seu primeiro nome</label>
                        <input type="text" name="nome" placeholder="Digite aqui" required>
                     </div> 
                     <div class="mb-0 botoes-cadastro mt-3">
                        <button type="submit" class="btn btn-primary"> 
                           Entrar
                        </button>
                     </div>
                     <a href="https://wa.me/56974909926?text=Hola,%20Olvide%20miu%20ID%20para%20ingresar%20a%20su%20sistema..." target="_blank" style="color: #fff;font-size: 14px;line-height: 40px; text-decoration: underline;">Pedir ayuda vía whatsapp </a>
                     <br>
                     {{-- <img class="img-fluid mt-1" height="20" src="{{ Vite::asset('resources/images/mountain.png') }}" alt=""> --}}
                     <i class="derechos">Turismo Chile - Todos los Derechos Reservados</i>
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
