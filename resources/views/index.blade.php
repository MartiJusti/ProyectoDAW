@extends('layout')

@section('title', 'Página principal')

@section('content')
    <button class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded" id="btn-login">
        <a href="{{ route('auth.login') }}">
            Iniciar sesión
        </a>
    </button>

    <button class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
        <a href="{{ route('auth.register') }}">
            Crear cuenta
        </a>
    </button>

    <button class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded">
        <a href="{{ route('tasks.index') }}">
            Tareas
        </a>
    </button>

    <button class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded">
        <a href="{{ route('tasks.create') }}">
            Crear Tarea
        </a>
    </button>

    <button class="bg-pink-500 hover:bg-pink-600 text-white font-bold py-2 px-4 rounded">
        <a href="{{ route('messages.index') }}">
            Mensajes
        </a>
    </button>


    <button class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded" id="btn-logout">
        Cerrar sesión
    </button>

    <button class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-2 px-4 rounded">
        <a href="{{ route('users.account') }}">
            Perfil</a>
    </button>

    <button class="bg-purple-500 hover:bg-purple-600 text-white font-bold py-2 px-4 rounded">
        <a href="{{ route('calendar') }}">
            Calendario</a>
    </button>

@endsection

@section('scripts')
    <script defer>
        document.addEventListener('DOMContentLoaded', function() {

            const btnLogout = document.getElementById('btn-logout');
            const btnLogin = document.getElementById('btn-login');
            const accessToken = localStorage.getItem('accessToken');

            const apiUrl = 'http://127.0.0.1:8000/api/logout';

            if (accessToken) {
                btnLogin.style.display = 'none';
                btnLogout.style.display = 'block';
            } else {
                btnLogin.style.display = 'block';
                btnLogout.style.display = 'none';
            }

            btnLogout.addEventListener('click', function() {
                fetch(apiUrl, {
                        method: 'POST',
                        headers: {
                            'Authorization': `Bearer ${accessToken}`
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Error al cerrar sesión');
                        }
                        return response.json();
                    })
                    .then(data => {
                        localStorage.removeItem('accessToken');
                        window.location.href = "{{ route('auth.login') }}";
                    })
                    .catch(error => {
                        console.error('Error al cerrar sesión:', error);
                    });
            });
        });
    </script>
@endsection
