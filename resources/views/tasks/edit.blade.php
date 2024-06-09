@extends('layout')

@section('title', 'Editar tarea')

@section('content')
    <div class="max-w-2xl mx-auto mt-10">
        <h2 class="text-3xl font-bold mb-6 text-center">Editar Tarea</h2>
        <div class="bg-white shadow-md rounded-2xl px-8 pt-6 pb-8 mb-4">
            <form id="task-form">
                @csrf

                <div class="mb-4">
                    <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nombre</label>
                    <input type="text" name="name" id="name" value="{{ $task->name }}"
                        class="shadow appearance-none border rounded-xl w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        required>
                </div>
                <div class="mb-4">
                    <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Descripción</label>
                    <input type="text" name="description" id="description" value="{{ $task->description }}"
                        class="shadow appearance-none border rounded-xl w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        required>
                </div>
                <div class="mb-4">
                    <label for="date-start" class="block text-gray-700 text-sm font-bold mb-2">Fecha de Inicio</label>
                    <input type="date" name="date_start" id="date-start" value="{{ $task->date_start }}"
                        class="shadow appearance-none border rounded-xl w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        required>
                </div>
                <div class="mb-4">
                    <label for="date-end" class="block text-gray-700 text-sm font-bold mb-2">Fecha de Fin</label>
                    <input type="date" name="date_end" id="date-end" value="{{ $task->date_end }}"
                        class="shadow appearance-none border rounded-xl w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        required>
                </div>
                <div class="flex items-center justify-between">
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-2xl focus:outline-none focus:shadow-outline">
                        Guardar cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    @vite('resources/js/tasks/edit.js')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const taskId = @json($task->id);
            const accessToken = localStorage.getItem('accessToken');

            initializeEditTask(taskId, accessToken);
        });
    </script>
@endsection
