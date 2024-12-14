<nav class="content-top-menu">  
    <div class="menu-mobile">
        <i class="uil uil-bars"></i>
    </div>
    <ul>
        <li class="menu-usuario">
            <a href="#">
                <img  class="img-fluid" src="{{ Vite::asset('resources/images/avatar.png') }}" alt="">
                {{ Auth::user()->name }} <i class="uil uil-angle-down"></i>
                <ul class="sub-menu">
                    @if(Auth::check())
                      <li class="nav-item">
                            <a 
                              onclick="event.preventDefault(); 
                              document.getElementById('logout-form').submit();"> 
                              Deslogar
                            </a>
              
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form> 
                        </li>
                    @endif
                </ul>
            </a>
        </li>
    </ul> 
</nav>
<div class="content-lateral-menu">
    <div class="menu-logo">
        <img  class="img-fluid" src="{{ Vite::asset('resources/images/logo.svg') }}" alt="">
    </div>
    <div class="menu">
        <span>
            MENU
        </span>
        <ul>
            <li>
                <a href="{{ route("vincular-veiculos") }}" class="{{ request()->routeIs(['vincular-veiculos']) ? 'current' : '' }}">
                    <i class="uil uil-link"></i>
                    Vincular veículos
                </a>
            </li>            
            <li>
                <a href="{{ route("configurar-alertas") }}" class="{{ request()->routeIs(['configurar-alertas']) ? 'current' : '' }}">
                    <i class="uil uil-clock"></i>
                    Configurar alertas
                </a>
            </li>
        </ul>
    </div>
</div>