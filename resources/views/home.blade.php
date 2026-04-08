@extends('layout.masterdash')

@section('content')
<div class="row mb-4 animate__animated animate__fadeIn">
    <div class="col-12 d-flex align-items-center">
        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px;">
            <i class="fas fa-user-cog fa-lg"></i>
        </div>
        <div>
            <h2 class="mb-0 fw-bold">Mi Cuenta</h2>
            <p class="text-muted mb-0">Gestiona tu información personal y perfil</p>
        </div>
    </div>
</div>

<div class="row g-4 animate__animated animate__fadeInUp">
    <div class="col-lg-8">
        <div class="card h-100 shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold text-primary">Información Personal</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label text-muted small text-uppercase">Email / Usuario</label>
                        <div class="d-flex align-items-center p-2 bg-light rounded border">
                            <i class="fas fa-envelope text-primary me-2 opacity-75"></i>
                            <span class="fw-medium">{{ Auth::user()->email }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted small text-uppercase">Nombre</label>
                        <div class="d-flex align-items-center p-2 bg-light rounded border">
                            <i class="fas fa-user text-primary me-2 opacity-75"></i>
                            <span class="fw-medium">{{ Auth::user()->name }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted small text-uppercase">RUT</label>
                        <div class="d-flex align-items-center p-2 bg-light rounded border">
                            <i class="fas fa-id-card text-primary me-2 opacity-75"></i>
                            <span class="fw-medium">{{ Auth::user()->rut }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted small text-uppercase">WhatsApp</label>
                        <div class="d-flex align-items-center p-2 bg-light rounded border">
                            <i class="fab fa-whatsapp text-success me-2 opacity-75"></i>
                            <span class="fw-medium">{{ Auth::user()->whatsapp }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted small text-uppercase">Perfil / Rol</label>
                        <div class="d-flex align-items-center p-2 bg-light rounded border">
                            <i class="fas fa-user-tag text-primary me-2 opacity-75"></i>
                            <span class="fw-medium">{{ Auth::user()->role }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted small text-uppercase">Contraseña</label>
                        <div class="d-flex align-items-center p-2 bg-light rounded border">
                            <i class="fas fa-lock text-warning me-2 opacity-75"></i>
                            <a href="{{ route('password.request') }}" class="text-decoration-none fw-medium">Cambiar Contraseña</a>
                        </div>
                    </div>
                </div>

                <hr class="my-4 opacity-50">

                <h6 class="fw-bold mb-3">Actualizar Foto de Perfil</h6>
                <form action="{{ route('users.updatePhoto', Auth::user()->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row align-items-end g-3">
                        <div class="col-md-8">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0"><i class="fas fa-image text-muted"></i></span>
                                <input type="file" name="photo" class="form-control border-start-0" accept="image/*" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-upload me-2"></i> Actualizar Foto
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow-sm border-0 text-center py-4 h-100">
            <div class="card-body d-flex flex-column align-items-center justify-content-center">
                <div class="position-relative mb-4">
                    <div class="rounded-circle border border-4 border-primary p-1 shadow-sm overflow-hidden" style="width: 180px; height: 180px;">
                        @if(Auth::user()->photo)
                            <img src="{{ asset('' . Auth::user()->photo) }}" alt="Foto del usuario" class="img-fluid rounded-circle h-100 w-100 object-fit-cover">
                        @else
                            <img src="{{ Vite::asset('resources/images/avatar.png') }}" alt="Foto padrão" class="img-fluid rounded-circle h-100 w-100 object-fit-cover opacity-50">
                        @endif
                    </div>
                    <div class="position-absolute bottom-0 end-0 bg-success border border-4 border-white rounded-circle shadow-sm" style="width: 30px; height: 30px;" title="Online"></div>
                </div>
                <h4 class="fw-bold mb-1">{{ Auth::user()->name }}</h4>
                <p class="text-primary fw-medium mb-3">{{ Auth::user()->role }}</p>
                <div class="d-flex gap-2">
                    <span class="badge bg-light text-dark border px-3 py-2 rounded-pill shadow-sm">
                        <i class="fas fa-calendar-alt me-1 text-primary"></i> Miembro desde {{ Auth::user()->created_at->format('M Y') }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
