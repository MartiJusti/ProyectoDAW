@extends('layout')

@section('title', 'Mensajes')

@section('content')
    <div class="mt-12 ml-3 md:mt-8 md:ml-0">
        <h1 class="text-center mb-8 text-2xl font-bold">¿A quién quieres enviar un mensaje?</h1>
        <div class="w-full md:w-3/12 mx-auto">
            <input type="text" id="search" placeholder="Buscar usuarios..." class="mb-4 p-2 border rounded-xl w-full">
        </div>
        <div class="max-w-sm mx-auto p-4 bg-white rounded-lg shadow-lg">
            <div id="users-list"></div>
        </div>
    </div>
@endsection



@section('scripts')
    @vite('resources/js/messages/index.js')
@endsection
