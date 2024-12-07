<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'test') }}</title>

        <link rel="stylesheet" href="{{ asset('/css/base.css') }}">
        <link rel="stylesheet" href="{{ asset('/css/popup.css') }}">
        <link rel="stylesheet" href="{{ asset('/css/comments.css') }}">
        <link rel="stylesheet" href="{{asset('/css/footer.css')}}">
        @yield('styles')

        <!-- Scripts -->
{{--        @vite(['resources/css/app.css', 'resources/js/app.js'])--}}
    </head>
    <body class="font-sans antialiased">
        @include('components.header')
        @include('components.menu')
        @include('components.add-comment')
        @yield('content')
        @include('components.footer')
    </body>
    <script src="{{ asset('js/jquery3.6.4.min.js') }}"></script>
    @include('components.base')
    @yield('scripts')
</html>
