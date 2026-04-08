@php
    $permissions = Auth::check() ? (is_string(Auth::user()->permissions) ? json_decode(Auth::user()->permissions, true) : Auth::user()->permissions) : [];
@endphp

<!-- Top Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top shadow-sm">
    <div class="container-fluid">
        <button class="btn btn-link text-white me-3 menu-mobile d-lg-none" type="button">
            <i class="fas fa-bars fa-lg"></i>
        </button>
        
        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
            <img src="{{ Vite::asset('resources/images/logo.jpeg') }}" alt="Alfatur" height="40" class="me-2 rounded">
            <span class="fw-bold d-none d-sm-inline">ALFATUR</span>
        </a>

        @if(Auth::check())
            <div class="ms-auto d-flex align-items-center">
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="text-end me-2 d-none d-md-block">
                            <div class="fw-bold lh-1">{{ Auth::user()->name }}</div>
                            <small class="opacity-75">{{ Auth::user()->role }}</small>
                        </div>
                        <div class="bg-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="fas fa-user text-primary"></i>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0" aria-labelledby="userDropdown">
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('home') }}">
                                <i class="fas fa-user-circle me-2 opacity-50"></i> Mi Cuenta
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt me-2 opacity-50"></i> Deslogar
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        @endif
    </div>
</nav>

<!-- Sidebar Navigation -->
<aside class="sidebar bg-white shadow-sm" id="sidebar">
    <div class="p-3">
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs(['home']) ? 'active' : 'link-dark' }}">
                    <i class="fas fa-home me-2"></i> Dashboard
                </a>
            </li>

            @if(in_array('usuarios.create', $permissions))
            <li class="nav-item">
                <a href="{{ route('usuarios.create') }}" class="nav-link {{ request()->routeIs(['usuarios.create']) ? 'active' : 'link-dark' }}">
                    <i class="fas fa-users me-2"></i> Usuarios
                </a>
            </li>
            @endif

            @if(in_array('viajes.vendedor', $permissions))
            <li class="nav-item">
                <a href="{{ route('viajes.vendedor') }}" class="nav-link {{ request()->routeIs(['viajes.vendedor']) ? 'active' : 'link-dark' }}">
                    <i class="fas fa-route me-2"></i> Viajes/Vendedor
                </a>
            </li>
            @endif

            @if(in_array('logistica.index', $permissions))
            <li class="nav-item">
                <a href="{{ route('logistica.index') }}" class="nav-link {{ request()->routeIs(['logistica.index']) ? 'active' : 'link-dark' }}">
                    <i class="fas fa-truck me-2"></i> Logística
                </a>
            </li>
            @endif

            @if(in_array('viajes.full', $permissions))
            <li class="nav-item">
                <a href="{{ route('viajes.full') }}" class="nav-link {{ request()->routeIs(['viajes.full']) ? 'active' : 'link-dark' }}">
                    <i class="fas fa-globe me-2"></i> Viajes FULL
                </a>
            </li>
            @endif

            @if(in_array('pagos.full', $permissions))
            <li class="nav-item">
                <a href="{{ route('pagos.full') }}" class="nav-link {{ request()->routeIs(['pagos.full']) ? 'active' : 'link-dark' }}">
                    <i class="fas fa-money-bill-wave me-2"></i> Pagos FULL
                </a>
            </li>
            @endif

            @if(in_array('vendas.create', $permissions))
            <li class="nav-item">
                <a href="{{ route('vendas.create') }}" class="nav-link {{ request()->routeIs(['vendas.create']) ? 'active' : 'link-dark' }}">
                    <i class="fas fa-cart-plus me-2"></i> Vender
                </a>
            </li>
            @endif

            @if(in_array('vendas.list', $permissions))
            <li class="nav-item">
                <a href="{{ route('vendas.list') }}" class="nav-link {{ request()->routeIs(['vendas.list']) ? 'active' : 'link-dark' }}">
                    <i class="fas fa-list me-2"></i> Mis Vendas
                </a>
            </li>
            @endif

            @if(in_array('estimativo.index', $permissions))
            <li class="nav-item">
                <a href="{{ route('estimativo.index') }}" class="nav-link {{ request()->routeIs(['estimativo.index']) ? 'active' : 'link-dark' }}">
                    <i class="fas fa-calculator me-2"></i> Estimativo
                </a>
            </li>
            @endif

            @if(in_array('tours.create', $permissions))
            <li class="nav-item">
                <a href="{{ route('tours.create') }}" class="nav-link {{ request()->routeIs(['tours.create']) ? 'active' : 'link-dark' }}">
                    <i class="fas fa-map-marked-alt me-2"></i> Tours
                </a>
            </li>
            @endif
        </ul>
    </div>
</aside>