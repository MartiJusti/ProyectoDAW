@extends('layout')

@section('title', 'Perfil de Usuario')

@section('content')
    <div class="container mx-auto py-8 px-4">
        <div class="max-w-md mx-auto bg-white shadow-md rounded-md overflow-hidden">
            <div class="p-6">
                <h2 class="text-2xl font-semibold mb-4 text-center text-gray-800">Datos del Usuario</h2>
                <div class="flex flex-col space-y-4">
                    {{-- <div class="flex justify-center">
                        <img src="{{ Avatar::create('Joko Widodo')->toBase64() }}">
                    </div> --}}
                    <div class="flex items-center">
                        <span class="font-semibold w-1/3 text-gray-600">Nombre:</span>
                        <span id="name" class="w-2/3 text-gray-800"></span>
                    </div>
                    <div class="flex items-center">
                        <span class="font-semibold w-1/3 text-gray-600">Nombre de Usuario:</span>
                        <span id="username" class="w-2/3 text-gray-800"></span>
                    </div>
                    <div class="flex items-center">
                        <span class="font-semibold w-1/3 text-gray-600">Correo Electrónico:</span>
                        <span id="email" class="w-2/3 text-gray-800"></span>
                    </div>
                    <div class="flex items-center">
                        <span class="font-semibold w-1/3 text-gray-600">Fecha de Nacimiento:</span>
                        <span id="birthday" class="w-2/3 text-gray-800"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @vite('resources/js/user/account.js')
@endsection
