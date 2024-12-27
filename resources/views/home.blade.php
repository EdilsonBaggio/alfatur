@extends('layout.masterdash')
@section('content')
<div class="container">
    <div class="tit-mi-conta">
        <svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M22 0C9.94783 0 0 9.94783 0 22C0 34.0522 9.94783 44 22 44C34.0522 44 44 34.1478 44 22C44 9.85218 34.1478 0 22 0ZM22 6.6C25.7304 6.6 28.6 9.46956 28.6 13.2C28.6 16.9304 25.7304 19.8 22 19.8C18.2696 19.8 15.4 16.9304 15.4 13.2C15.4 9.46956 18.2696 6.6 22 6.6ZM22 37.8782C16.5478 37.8782 11.6696 35.0087 8.8 30.8C8.8 26.4 17.6 24.0087 22 24.0087C26.4 24.0087 35.2 26.4 35.2 30.8C32.3304 35.0087 27.5478 37.8782 22 37.8782Z" fill="#EDEDED"/>
        </svg>
        <h2>Mi conta</h2>
    </div>
    <div class="content-dados-conta">
        <div class="row">
            <div class="col-md-6 order-1">
                <div class="d-flex">
                    <div><i class="bi bi-person-circle"></i> Usuário:</div> {{ Auth::user()->email }}
                </div>
                <div class="d-flex">
                    <div><i class="bi bi-lock-fill"></i>Contraseña:</div> <a href="{{ route('password.request') }}">Cambiar Contraseña</a>
                </div>
                <div class="d-flex">
                    <div><i class="bi bi-person-circle"></i>Nombre:</div> {{ Auth::user()->name }}
                </div>
                <div class="d-flex">
                    <div><i class="bi bi-person-fill-gear"></i>RUT:</div> {{ Auth::user()->rut }}
                </div>
                <div class="d-flex">
                    <div><i class="bi bi-whatsapp"></i>Whatsapp:</div> {{ Auth::user()->whatsapp }}
                </div>
                <div class="d-flex">
                    <div><i class="bi bi-person-arms-up"></i>Perfil:</div> {{ Auth::user()->role }}
                </div>
                <form action="{{ route('users.updatePhoto', Auth::user()->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                
                    <div class="d-flex">
                        <div class="align-self-center"><i class="bi bi-person-arms-up"></i> Foto:</div>
                        <div>
                            <input type="file" name="photo" class="form-control" accept="image/*" required>
                        </div>
                    </div>
                    <div class="d-flex">
                        <button type="submit" class="btn btn-primary mt-2">Atualizar Foto</button>
                    </div>
                </form>  
            </div>
            <div class="col-md-6 order-2">
                <div class="text-center">
                    @if(Auth::user()->photo) <!-- Verifica se o usuário possui uma foto cadastrada -->
                        <img class="img-fluid" src="{{ asset('storage/' . Auth::user()->photo) }}" alt="Foto do usuário">
                    @else
                        <img class="img-fluid" src="{{ Vite::asset('resources/images/foto.png') }}" alt="Foto padrão">
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
@endsection