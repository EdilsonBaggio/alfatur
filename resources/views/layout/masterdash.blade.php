<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('layout.head')
    <body class="bg-light">
        <div id="app" class="d-flex flex-column min-vh-100">
            @include('layout.header')
            
            <div class="d-flex flex-grow-1 main-wrapper">
                <main class="main-content flex-grow-1 p-3 p-md-4">
                    <div class="container-fluid">
                        @yield('content')
                    </div>
                </main>
            </div>

            @include('layout.footer')
        </div>

        @livewireScripts
        @include('layout.scripts')
    </body>
</html>