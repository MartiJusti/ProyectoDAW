@extends('layout')

@section('title', 'Iniciar sesión')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                    Iniciar sesión
                </h2>
            </div>
            <form id="login-form" class="mt-8 space-y-6">
                @csrf
                <div class="rounded-md shadow-sm -space-y-px">
                    <div>
                        <label for="email" class="sr-only">Correo electrónico</label>
                        <input id="email" name="email" type="email" autocomplete="email" required
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                            placeholder="Correo electrónico">
                    </div>
                    <div>
                        <label for="password" class="sr-only">Contraseña</label>
                        <input id="password" name="password" type="password" autocomplete="current-password" required
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                            placeholder="Contraseña">
                    </div>
                </div>

                <div class="flex items-center justify-between">

                    <div class="text-sm">
                        <a href="{{route('auth.register')}}" class="font-medium text-indigo-600 hover:text-indigo-500">
                            ¿No tienes cuenta?
                        </a>
                    </div>
                </div>

                <div>
                    <button id="login-btn" type="submit"
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M6 3a1 1 0 00-1 1v10.586l.707.707L9 18.414V19a1 1 0 102 0v-.586l3.293-3.293.707-.707V4a1 1 0 00-1-1H6zm4 10V6h4v7h-2v-2h-2v2H7v-3a1 1 0 00-1-1H4a1 1 0 00-1 1v5a1 1 0 001 1h1a1 1 0 001-1v-3h2v2h2v-2h2v2h2v-4h-2z"
                                    clip-rule="evenodd" />
                            </svg>
                        </span>
                        Iniciar sesión
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loginForm = document.getElementById('login-form');
            const loginBtn = document.getElementById('login-btn');

            const apiUrl = 'http://127.0.0.1:8000/api/login';

            loginForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(loginForm);
                fetch(apiUrl, {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(
                                'Usuario no autorizado. Por favor, verifique sus credenciales.');
                        }
                        return response.json();
                    })
                    .then(data => {
                        const accessToken = data['access-token'];
                        console.log('Token de acceso:', accessToken);

                        localStorage.setItem('accessToken', accessToken);
                        window.location.href = '/';
                    })
                    .catch(error => {
                        console.error('Error al iniciar sesión:', error.message);
                        alert(error.message);
                    });
            });
        });
    </script>
@endsection
