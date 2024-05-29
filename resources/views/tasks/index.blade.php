@extends('layout')

@section('title', 'Tareas')

@section('content')
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold mt-8 mb-4">Listado de Tareas</h1>

        <div id="task-list" class="grid grid-cols-1 md:grid-cols-2 gap-4">
        </div>
    </div>
@endsection

@section('scripts')
    @vite('resources/js/tasks/index.js')
@endsection
