@extends('layout')

@section('title', 'Página principal')

@section('content')
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold mt-8 mb-4">Listado de Tareas</h1>

        <div>
            <input type="text" id="search" placeholder="Buscar tareas..." class="mb-4 p-2 border rounded w-3/5 md:w-3/12">
        </div>

        <div id="task-list" class="grid grid-cols-1 md:grid-cols-2 gap-4">
        </div>
    </div>
@endsection

@section('scripts')
    @vite('resources/js/tasks/index.js')
@endsection
