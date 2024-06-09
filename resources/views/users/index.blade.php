@extends('layout')

@section('title', 'Usuarios')

@section('content')
    <div class="p-4">
        <h1 class="text-xl md:text-2xl font-bold mb-4">Lista de Usuarios</h1>
        <div>
            <input type="text" id="search" placeholder="Buscar usuarios..."
                class="mb-4 p-2 border rounded-xl w-5/6 md:w-3/12">
        </div>

        <div id="users-container" class="bg-gray-100 p-4 rounded-2xl shadow-md">
        </div>
    </div>
@endsection

@section('scripts')
    @vite('resources/js/user/index.js')
@endsection
