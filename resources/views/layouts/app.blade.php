<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{ asset('/css/base.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/popup.css') }}">
    @yield('styles')
</head>
<body>
@include('components.header')
@include('components.menu')
@yield('content')
@include('components.footer')
<script src="{{ asset('js/jquery3.6.4.min.js') }}"></script>
<script src="{{ asset('scripts/base.js') }}"></script>
@yield('scripts')
</body>
</html>
