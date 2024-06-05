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
</head>

<body class="loading @yield('body-class', '') bg-slate-100">
    <div class="flex min-h-screen">
        <div class="flex-1 p-10">
            @yield('content')
        </div>
        @include('partials.sidebar')
    </div>
    @yield('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const accessToken = localStorage.getItem('accessToken');
            const isPublicView = document.body.classList.contains('public-view');
            const currentPath = window.location.pathname;

            if (!accessToken && !isPublicView && currentPath !== '{{ route('auth.login') }}') {
                document.title = 'Redirigiendo a Login...';
                window.location.href = "{{ route('auth.login') }}";
            } else {
                document.title = '@yield('title')';
                document.body.classList.remove('loading');
            }
        });
    </script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
</body>

</html>
