<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Toko Komputer')</title>
    {{-- Memuat CSS dari folder public --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="container @yield('container-class')">
        @yield('content')
    </div>
</body>
</html>