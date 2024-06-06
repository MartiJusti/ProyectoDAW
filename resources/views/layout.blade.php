<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    @yield('styles')
    @vite(['resources/css/app.css', 'resources/css/layout/style.css'])
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.js"></script>
</head>

<body class="loading @yield('body-class', '') bg-slate-100">
    <div class="flex min-h-screen">
        <div class="flex-1 p-10">
            @yield('content')
        </div>
        @include('partials.sidebar')
    </div>
    @yield('scripts')


    @vite('/resources/js/layout.js')
    {{-- El script de ToastifyJS se coloca aquí porque la página web lo dice --}}
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
</body>

</html>
