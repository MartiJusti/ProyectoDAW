<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}

    @yield('styles')
    @vite('resources/css/app.css')
</head>

<body>

    <div class="flex min-h-screen">
        <div class="flex-1 p-10">
            @yield('content')
        </div>

        @include('partials.sidebar')
    </div>

    @yield('scripts')
</body>

</html>
