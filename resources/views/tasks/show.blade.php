@extends('layout')

@section('title', 'Tarea')

@section('styles')
    @vite('resources/css/tasks/show.css')
@endsection

@section('content')
    <div class="p-4 space-y-4 mt-6 flex flex-col items-center">

        <div class="flex flex-wrap justify-center items-stretch w-full md:gap-8">
            <div id="task-info"
                class="w-full md:w-2/5 mb-4 p-4 bg-gray-200 rounded shadow-md flex flex-col items-center justify-center space-y-5 order-1">
                <span class="font-bold text-lg md:text-3xl">{{ $task->name }}</span>
                <span class="text-sm md:text-xl">{{ $task->description }}</span>
                <span id="category-list" class="text-xs md:text-sm">
                </span>
            </div>

            <div id="scores" class="w-full md:w-2/5 mb-4 p-4 rounded shadow-md order-3 md:order-2">
                <div id="task-users" class="rounded shadow-md"></div>
            </div>

            <div id="categories" class="w-full md:w-2/5 mb-4 bg-pink-200 rounded-md p-4 flex flex-col justify-between order-2 md:order-3">
                <label for="category-select" class="block text-gray-700 text-sm font-bold mb-2">
                    Asignar nueva categoría:
                </label>
                <div class="relative">
                    <select id="category-select"
                        class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                        <option value="">Seleccione una categoría</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <i class="fa-solid fa-angle-down"></i>
                    </div>
                </div>
                <button id="assign-category"
                    class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 mt-2 rounded">
                    Asignar Categoría
                </button>
            </div>

            <div id="users" class="w-full md:w-2/5 mb-4 bg-green-200 rounded-md p-4 flex flex-col justify-between order-4">
                <label for="user-select" class="block text-gray-700 text-sm font-bold mb-2">
                    Asignar nuevo usuario:
                </label>
                <div class="relative">
                    <select id="user-select"
                        class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                        <option value="">Seleccione un usuario</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <i class="fa-solid fa-angle-down"></i>
                    </div>
                </div>
                <button id="assign-user"
                    class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 mt-2 rounded">
                    Asignar Usuario
                </button>
            </div>
        </div>

        <div id="supervisor-panel" class="space-y-4 w-full">
            <div class="flex justify-center space-x-4 mb-4 w-full">
                <button class="bg-yellow-500 hover:bg-[#d9a507] text-white font-bold py-2 px-4 rounded-2xl">
                    <a href="{{ route('tasks.edit', $task->id) }}">Editar Tarea</a>
                </button>

                <button id="delete-task" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-2xl">
                    Eliminar Tarea
                </button>
            </div>
        </div>
    </div>
@endsection




@section('scripts')
    @vite(['resources/js/tasks/users.js', 'resources/js/tasks/destroy.js', 'resources/js/categories/main.js', 'resources/js/scores/main.js'])

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const accessToken = localStorage.getItem('accessToken');
            const taskId = @json($task->id);
            let users = [];
            let categories = [];

            const apiUrl = 'http://127.0.0.1:8000/api';

            initializeDeleteTask(apiUrl, taskId, accessToken);

            initializeCategoryFunctions(apiUrl, taskId, categories, accessToken);

            initializeUserAndScoreFunctions(apiUrl, taskId, users, accessToken);

        });
    </script>


@endsection
