@extends('layout')

@section('title', 'Iniciar sesión')

@section('body-class', 'public-view')

@section('content')
    <div class="min-h-screen flex items-center justify-center px-4 md:px-8">
        <div class="max-w-md w-full space-y-8">
            <div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                    Iniciar sesión
                </h2>
            </div>
            <form id="login-form" class="mt-8 space-y-6">
                @csrf
                <div class="rounded-2xl shadow-sm -space-y-px">
                    <div class="mb-4">
                        <label for="email" class="sr-only">Correo electrónico</label>
                        <input id="email" name="email" type="email" required
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 text-sm"
                            placeholder="Correo electrónico">
                    </div>
                    <div>
                        <label for="password" class="sr-only">Contraseña</label>
                        <input id="password" name="password" type="password" required
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 text-sm"
                            placeholder="Contraseña">
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="text-sm">
                        <a href="{{ route('auth.register') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                            ¿No tienes cuenta?
                        </a>
                    </div>
                </div>

                <div>
                    <button id="login-btn" type="submit"
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-2xl text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Iniciar sesión
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    @vite('resources/js/auth/login.js')
@endsection
