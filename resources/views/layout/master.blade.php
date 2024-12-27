<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('layout.head')
    <body class="bg-login">
        @yield('content')
        @livewireScripts
    </body>
    @include('layout.scripts')
</html>