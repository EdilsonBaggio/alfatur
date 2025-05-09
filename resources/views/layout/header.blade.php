<nav class="content-top-menu"> 
    <div class="container">
        <div class="group-menu-logo">
            <div class="menu-mobile">
                <i class="uil uil-bars"></i>
            </div>
            <div class="menu-logo">
                <img class="img-fluid" src="{{ Vite::asset('resources/images/logo.svg') }}" alt="">
            </div>
            @if(Auth::check())
                <div class="d-flex menu-top-logado">
                    <div> 

                        <svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M22.0001 31.453H22.1721C22.1796 31.7966 22.4991 33.1912 22.7154 34.1354C22.7868 34.4469 22.8469 34.7094 22.8809 34.8689C23.0448 35.6378 23.2289 36.4743 23.407 37.2839C23.4772 37.6028 23.5465 37.9175 23.6132 38.2223L22.0663 39.7228L20.5392 38.2421C20.795 37.1438 21.0628 35.9406 21.291 34.8689C21.3251 34.7092 21.3853 34.4464 21.4567 34.1346C21.6731 33.1904 21.9924 31.7965 22.0001 31.453ZM29.576 8.49433C29.8938 9.28433 30.3784 11.2824 30.2502 11.9452L30.1304 12.8568C29.9399 14.2003 29.4391 15.4624 28.6428 16.5255C28.0284 17.3457 27.4055 17.9814 26.5392 18.5469C24.1097 20.1336 21.0639 20.3562 18.4465 19.1083C16.1373 18.0069 14.4179 15.8251 13.9447 13.2977C13.3351 10.0423 14.49 7.29313 16.8701 5.2683C19.1989 3.28718 22.8038 2.95549 25.5537 4.26677C26.8524 4.88607 28.0726 5.94301 28.8596 7.14833C29.1373 7.57355 29.376 7.99662 29.576 8.49433ZM32.1975 17.416C33.3916 15.2448 33.6875 13.6543 33.6875 11.1717C33.6875 9.62537 33.0925 7.73616 32.5707 6.70279C31.2191 4.02574 29.6634 2.4693 26.9847 1.11683C25.1812 0.206135 23.6202 0 21.4844 0C19.4047 0 16.7117 1.03355 15.2232 2.16046C13.8587 3.19329 13.4709 3.59189 12.4359 4.95928C11.3376 6.41032 10.3127 9.13467 10.3127 11.1717C10.3127 14.662 11.0777 16.7719 13.2216 19.4347C13.4185 19.6794 13.8281 20.0862 14.0731 20.3021C14.1526 20.3722 14.2622 20.4574 14.3782 20.5477C14.6029 20.7225 14.8517 20.916 14.9532 21.0547C13.2379 21.4542 10.1188 23.2414 8.6663 24.3068L7.19566 25.5001C7.08193 25.6097 6.98302 25.7132 6.88538 25.8155C6.76682 25.9396 6.65014 26.0618 6.51106 26.1904L5.47931 27.2213C5.4314 27.2725 5.39101 27.3109 5.35213 27.3479C5.29787 27.3995 5.24655 27.4483 5.18179 27.5253L4.54037 28.2588C4.49597 28.3148 4.45073 28.3715 4.40499 28.4288C3.51138 29.5484 2.42662 30.9076 3.62733 32.0368C4.29574 32.6655 5.24224 32.7416 5.99482 32.1196C6.1576 31.985 6.35024 31.7036 6.51649 31.4608C6.56995 31.3827 6.62069 31.3086 6.66683 31.2447C6.71218 31.1818 6.75451 31.1226 6.79507 31.0659C6.97253 30.8178 7.11624 30.6168 7.33146 30.3624C8.59363 28.8689 9.66927 27.858 11.2583 26.7268C11.4343 26.6014 11.6154 26.4909 11.797 26.3801C11.9327 26.2973 12.0688 26.2143 12.2031 26.1248C12.3895 26.0005 12.5712 25.9017 12.7614 25.7982C12.8967 25.7246 13.0363 25.6487 13.1849 25.5596C14.8075 24.5867 18.2976 23.6188 20.1954 23.4608L18.5456 31.0921C18.2609 32.3079 17.9688 33.6609 17.7103 34.8975C17.651 35.1816 17.5869 35.4665 17.5234 35.7485C17.4427 36.1069 17.3631 36.4608 17.2955 36.8031C17.2274 37.1481 17.16 37.4407 17.1013 37.6953C16.8076 38.9695 16.7333 39.2917 17.8967 40.4549L20.4318 42.99C20.506 43.0643 20.5738 43.1347 20.6378 43.2011C21.0707 43.6507 21.3241 43.9138 22.1721 43.9138C22.9404 43.9138 23.7504 43.0515 24.5028 42.2506C24.682 42.0597 24.858 41.8724 25.0293 41.701C25.3719 41.3585 25.6674 41.074 25.9207 40.8302C27.3036 39.4989 27.4269 39.3803 27.0634 37.6476C27.0357 37.5155 27.0089 37.3992 26.9818 37.2815C26.9438 37.1163 26.9052 36.9486 26.8626 36.7312C26.745 36.1302 26.2767 34.0335 25.7505 31.6776C24.9363 28.0323 23.9835 23.7663 23.9767 23.4608C24.0264 23.4847 24.1918 23.5106 24.4526 23.5515C25.9019 23.7788 30.2965 24.4679 34.1365 27.8244C34.2262 27.9029 34.3112 27.9741 34.3938 28.0434C34.5691 28.1904 34.7341 28.3288 34.9125 28.5093C36.2076 29.8195 37.1506 30.8234 38.1523 32.4881C38.6675 33.3442 39.2436 34.468 39.6059 35.4174C39.6732 35.5937 39.7276 35.757 39.7819 35.92C39.8441 36.1064 39.9061 36.2925 39.987 36.4971C40.1396 36.8821 40.5416 38.4387 40.5312 38.8351C40.5108 39.6077 40.0182 40.2196 39.3206 40.4376C38.5934 40.6649 36.3537 40.6135 34.3374 40.5672C32.7226 40.5302 31.2512 40.4964 30.815 40.6117C28.9026 41.1174 29.2945 43.9998 31.1954 43.9998H39.1015C41.5426 43.9998 44 41.5818 44 39.1013C44 36.842 42.9886 34.2469 42.0236 32.3122C41.3526 30.9675 40.6001 29.7566 39.666 28.5683L38.781 27.4767C38.6318 27.3217 38.4851 27.1665 38.339 27.0119C37.8291 26.4724 37.3274 25.9415 36.756 25.4628C35.9982 24.8282 35.3075 24.2584 34.4793 23.7003C33.3213 22.92 30.4545 21.3824 29.047 21.0547C29.117 20.959 29.2943 20.8137 29.5215 20.6273C29.9025 20.3149 30.4238 19.8874 30.8157 19.386C30.8715 19.3145 30.9262 19.245 30.9797 19.1768C31.4349 18.5971 31.8123 18.1163 32.1975 17.416ZM3.51453 38.2962C3.51905 38.1857 3.52335 38.0807 3.52335 37.9841C3.52335 36.5005 1.51057 35.658 0.413528 37.0227C0.122493 37.3848 0 37.8719 0 38.4998C0 40.2234 0.392663 41.3492 1.52496 42.4748C2.00684 42.954 2.32054 43.199 2.97726 43.5147C3.46346 43.7482 4.22072 43.9998 4.89848 43.9998H13.0624C14.6888 43.9998 15.2761 41.8246 14.0242 40.8896C13.5795 40.5575 13.2121 40.559 12.4666 40.562L12.4611 40.5621C12.2873 40.5628 12.0098 40.5649 11.6617 40.5675C9.70348 40.5824 5.50995 40.6144 4.95694 40.5038C3.43656 40.2003 3.48155 39.1015 3.51453 38.2962Z"/>
                        </svg>
                            
                        <div class="d-grid">
                            <p>Hola, {{ Auth::user()->name }}</p>
                            <span>{{ Auth::user()->role }}</span>
                        </div>
                    </div>
                    <div class="mobile-none">
                        <svg class="{{ request()->routeIs(['home']) ? 'current' : '' }}" width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M22 0C9.94783 0 0 9.94783 0 22C0 34.0522 9.94783 44 22 44C34.0522 44 44 34.1478 44 22C44 9.85218 34.1478 0 22 0ZM22 6.6C25.7304 6.6 28.6 9.46956 28.6 13.2C28.6 16.9304 25.7304 19.8 22 19.8C18.2696 19.8 15.4 16.9304 15.4 13.2C15.4 9.46956 18.2696 6.6 22 6.6ZM22 37.8782C16.5478 37.8782 11.6696 35.0087 8.8 30.8C8.8 26.4 17.6 24.0087 22 24.0087C26.4 24.0087 35.2 26.4 35.2 30.8C32.3304 35.0087 27.5478 37.8782 22 37.8782Z"/>
                        </svg>
                        <a href="{{ route("home") }}" class="{{ request()->routeIs(['home']) ? 'current' : '' }}">
                            Mi Conta
                        </a>
                    </div>
                    <div>
                        <a style="cursor: pointer; display:flex; align-items: center;"
                            onclick="event.preventDefault(); 
                            document.getElementById('logout-form').submit();"> 
                            <svg width="40" height="44" viewBox="0 0 40 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M0 4.64068V33.7734C0 34.6613 0.349162 35.535 0.690537 36.0907C1.37653 37.2076 2.61615 37.8878 3.77649 38.5245C3.90272 38.5938 4.028 38.6625 4.15153 38.7313L11.886 43.2001C13.2474 43.9618 13.4863 44 14.9532 44C16.2444 44 17.3437 43.1953 18.1557 42.3899C19.4536 41.1025 19.4397 39.4079 19.425 37.6144C19.4235 37.4236 19.4219 37.2317 19.4219 37.0391H26.0392C27.5903 37.0391 28.801 36.4744 29.5853 35.6868C30.024 35.2462 30.3321 34.9184 30.6253 34.3205C30.8559 33.8503 31.1095 32.9741 31.1095 32.3126V26.8125C31.1095 25.0141 28.3486 24.6768 27.9614 26.5003C27.8292 27.1229 27.8773 28.1217 27.9281 29.1753C28.0069 30.8111 28.0921 32.579 27.5186 33.2763C27.354 33.4765 26.8863 33.7734 26.5547 33.7734H19.4219V13.2343C19.4219 11.8037 18.9912 10.2002 17.9375 9.3049C17.4738 8.91089 17.0778 8.68004 16.581 8.39044C16.4845 8.33417 16.3841 8.27568 16.2787 8.21334L7.64846 3.17962H23.2032C25.6103 3.17962 26.8093 3.03664 27.3995 3.5688C28.1217 4.22002 27.9323 5.88225 27.9297 10.0547C27.9296 10.1966 27.9272 10.324 27.925 10.4405C27.9143 11.0065 27.9084 11.3133 28.1989 11.7621C29.0501 13.0781 31.1095 12.3888 31.1095 10.9141V4.64068C31.1095 2.23071 28.9144 0 26.5547 0H4.55467C2.17018 0 0 2.25725 0 4.64068ZM33.0638 16.0862C32.4266 15.4915 31.711 14.8236 31.711 14.0079C31.711 13.6886 31.9453 13.1872 32.2433 12.9075C33.4196 11.8037 34.4715 12.9102 35.0211 13.4884C35.0758 13.5459 35.1255 13.5982 35.1699 13.6426L38.1778 16.6504C38.2162 16.6887 38.2579 16.7296 38.3021 16.7729C38.9278 17.3855 40.0417 18.4763 38.8666 19.6166C38.8376 19.6447 38.8105 19.6706 38.7847 19.6953C38.6756 19.7997 38.5902 19.8814 38.4872 20.0107C37.9722 20.6563 37.5605 21.0315 37.0596 21.4881C36.9034 21.6305 36.7385 21.7808 36.5591 21.9497L35.9165 22.596C35.7666 22.7396 35.6061 22.9191 35.4353 23.11C34.8726 23.7393 34.1992 24.4923 33.4297 24.4923C32.3727 24.4923 31.711 23.7097 31.711 22.8594C31.711 22.2651 32.1821 21.8121 32.5362 21.4717C32.5863 21.4235 32.634 21.3776 32.6778 21.3339C32.7724 21.2393 32.8832 21.1343 32.9996 21.024C33.3171 20.7232 33.6759 20.3833 33.8594 20.1094L22.7723 20.1105C22.0511 20.1156 21.6848 20.0523 21.288 19.7042C20.7169 19.2033 20.5458 18.511 20.9374 17.7577C21.3728 16.9199 21.9503 16.9237 22.714 16.9289C22.7617 16.9292 22.8101 16.9295 22.8593 16.9296H33.8594C33.6792 16.6605 33.3812 16.3824 33.0638 16.0862Z"/>
                            </svg> 
                            <p class="mobile-none">Deslogar</p>
                        </a>
            
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form> 
                    </div>
                </div>
            @endif
        </div>
    </div> 
</nav>
<div class="content-lateral-menu">
    <div class="container menu">
        <ul>
            <li class="mobile">
                <a href="{{ route('home') }}" class="{{ request()->routeIs(['home']) ? 'current' : '' }}">Mi cuenta</a>
            </li>
            
            @if(in_array('usuarios.create', is_string(Auth::user()->permissions) ? json_decode(Auth::user()->permissions, true) : Auth::user()->permissions))
            <li>
                <a href="{{ route('usuarios.create') }}" class="{{ request()->routeIs(['usuarios.create']) ? 'current' : '' }}">
                    Usuarios
                </a>
            </li>
            @endif

            @if(in_array('viajes.vendedor', is_string(Auth::user()->permissions) ? json_decode(Auth::user()->permissions, true) : Auth::user()->permissions))
            <li>
                <a href="{{ route('viajes.vendedor') }}" class="{{ request()->routeIs(['viajes']) ? 'current' : '' }}">
                    Viajes/Vendedor
                </a>
            </li>
            @endif

            @if(in_array('logistica.index', is_string(Auth::user()->permissions) ? json_decode(Auth::user()->permissions, true) : Auth::user()->permissions))
            <li>
                <a href="{{ route('logistica.index') }}" class="{{ request()->routeIs(['logistica.index']) ? 'current' : '' }}">
                    Logística
                </a>
            </li>
            @endif

            @if(in_array('realizadas_por_pagar', is_string(Auth::user()->permissions) ? json_decode(Auth::user()->permissions, true) : Auth::user()->permissions))
            <li>
                <a href="" class="{{ request()->routeIs(['realizadas-por-pagar']) ? 'current' : '' }}">
                    Realizadas Por Pagar
                </a>
            </li>
            @endif

            @if(in_array('viajes.full', is_string(Auth::user()->permissions) ? json_decode(Auth::user()->permissions, true) : Auth::user()->permissions))
            <li>
                <a href="{{ route('viajes.full') }}" class="{{ request()->routeIs(['viajes.full']) ? 'current' : '' }}">
                    Viajes FULL
                </a>
            </li>
            @endif

            @if(in_array('pagos.full', is_string(Auth::user()->permissions) ? json_decode(Auth::user()->permissions, true) : Auth::user()->permissions))
            <li>
                <a href="{{ route('pagos.full') }}" class="{{ request()->routeIs(['pagos.full']) ? 'current' : '' }}">
                    Pagos FULL
                </a>
            </li>
            @endif

            @if(in_array('vendas.create', is_string(Auth::user()->permissions) ? json_decode(Auth::user()->permissions, true) : Auth::user()->permissions))
            <li>
                <a href="{{ route('vendas.create') }}" class="{{ request()->routeIs(['vendas.create']) ? 'current' : '' }}">
                    Vender
                </a>
            </li>
            @endif

            @if(in_array('vendas.list', is_string(Auth::user()->permissions) ? json_decode(Auth::user()->permissions, true) : Auth::user()->permissions))
            <li>
                <a href="{{ route('vendas.list') }}" class="{{ request()->routeIs(['vendas.list']) ? 'current' : '' }}">
                    Mis Vendas
                </a>
            </li>
            @endif

            {{-- @if(in_array('confirmados', is_string(Auth::user()->permissions) ? json_decode(Auth::user()->permissions, true) : Auth::user()->permissions))
            <li>
                <a href="" class="{{ request()->routeIs(['confirmar-realizadas']) ? 'current' : '' }}">
                    Confirmados
                </a>
            </li>
            @endif --}}

            @if(in_array('estimativo.index', is_string(Auth::user()->permissions) ? json_decode(Auth::user()->permissions, true) : Auth::user()->permissions))
            <li>
                <a href="{{ route('estimativo.index') }}" class="{{ request()->routeIs(['estimativo.index']) ? 'current' : '' }}">
                    Estimativo
                </a>
            </li>
            @endif

            @if(in_array('tours.create', is_string(Auth::user()->permissions) ? json_decode(Auth::user()->permissions, true) : Auth::user()->permissions))
            <li>
                <a href="{{ route('tours.create') }}" class="{{ request()->routeIs(['tours.create']) ? 'current' : '' }}">
                    Tours
                </a>
            </li>
            @endif

            {{-- @if(in_array('mis_liquidaciones', is_string(Auth::user()->permissions) ? json_decode(Auth::user()->permissions, true) : Auth::user()->permissions))
            <li>
                <a href="" class="{{ request()->routeIs(['mis-liquidaciones']) ? 'current' : '' }}">
                    Mis Liquidaciones
                </a>
            </li>
            @endif --}}

            {{-- @if(in_array('liquidaciones', is_string(Auth::user()->permissions) ? json_decode(Auth::user()->permissions, true) : Auth::user()->permissions))
            <li>
                <a href="" class="{{ request()->routeIs(['liquidaciones']) ? 'current' : '' }}">
                    Liquidaciones
                </a>
            </li>
            @endif --}}
        </ul>
        <br style="clear: both">
    </div>
</div>


