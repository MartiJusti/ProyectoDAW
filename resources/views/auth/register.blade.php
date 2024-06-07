@extends('layout')

@section('title', 'Registro')

@section('body-class', 'public-view')

@section('content')
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div>
                <h2 id="register-title" class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                    Regístrate
                </h2>
            </div>
            <form class="mt-8 space-y-6" id="register-form">
                @csrf
                <div class="rounded-md shadow-sm">
                    <div class="mb-2">
                        <label for="name" class="sr-only">Nombre</label>
                        <input id="name" name="name" type="text" required
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                            placeholder="Nombre">
                    </div>
                    <div class="mb-2">
                        <label for="username" class="sr-only">Nombre</label>
                        <input id="username" name="username" type="text" required
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                            placeholder="Usuario">
                    </div>
                    <div class="mb-2">
                        <label for="email" class="sr-only">Correo electrónico</label>
                        <input id="email" name="email" type="email" required
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                            placeholder="Correo electrónico">
                    </div>
                    <div class="mb-2">
                        <label for="password" class="sr-only">Contraseña</label>
                        <input id="password" name="password" type="password" required
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                            placeholder="Contraseña">
                    </div>
                    <div class="mb-2">
                        <label for="birthday" class="sr-only">Fecha de nacimiento</label>
                        <input id="birthday" name="birthday" type="date" required
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                            placeholder="Fecha de nacimiento">
                    </div>
                    <div id="rol-select" class="mb-2">
                        <label for="role" class="sr-only">Rol</label>
                        <select id="role" name="rol"
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                            <option value="" disabled selected>Selecciona un rol</option>
                            <option value="supervisor">Supervisor</option>
                            <option value="participant">Participante</option>
                        </select>
                    </div>

                </div>

                <div>
                    <button type="submit" id="register-button"
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Registrarse
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    @vite('resources/js/auth/register.js')
@endsection
