<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }} - @yield('title')</title>

    {{-- Bootstrap & SCSS/JS --}}
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])

    {{-- Font đẹp, hỗ trợ tiếng Việt --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- Favicon --}}
    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}" type="image/png">
</head>
@stack('scripts')

<body class="d-flex flex-column min-vh-100">

    {{-- Header / Navbar --}}
    @include('partials.header')

    {{-- Thông báo alert --}}
    @include('partials.alerts')

    {{-- Nội dung chính --}}
    <main class="flex-fill">
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('partials.footer')

</body>

</html>
