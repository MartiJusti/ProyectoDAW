@extends('layout')

@section('title', 'Editar tarea')

@section('content')
    <div class="max-w-2xl mx-auto mt-10">
        <h2 class="text-3xl font-bold mb-6 text-center">Editar Tarea</h2>
        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <form id="task-form" method="POST">
                @csrf
                @method('PATCH')
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nombre</label>
                    <input type="text" name="name" id="name" value="{{ $task->name }}"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        required>
                    @error('name')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Descripción</label>
                    <input type="text" name="description" id="description" value="{{ $task->description }}"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        required>
                    @error('description')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="date-start" class="block text-gray-700 text-sm font-bold mb-2">Fecha de Inicio</label>
                    <input type="date" name="date_start" id="date-start" value="{{ $task->date_start }}"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        required>
                    @error('date_start')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="date-end" class="block text-gray-700 text-sm font-bold mb-2">Fecha de Fin</label>
                    <input type="date" name="date_end" id="date-end" value="{{ $task->date_end }}"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        required>
                    @error('date_end')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex items-center justify-between">
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Editar tarea
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const taskForm = document.getElementById('task-form');
            const accessToken = localStorage.getItem('accessToken');
            const taskId = @json($task->id);

            const apiUrl = 'http://127.0.0.1:8000/api/tasksAPI/';

            taskForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(taskForm);
                const jsonData = {};

                formData.forEach((value, key) => {
                    jsonData[key] = value;
                });

                fetch(`${apiUrl}${taskId}`, {
                        method: 'PATCH',
                        headers: {
                            'Authorization': `Bearer ${accessToken}`,
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(jsonData)
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Datos de tarea incorrectos.');
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log(data);
                        console.log(data.id);

                        Toastify({
                            text: "¡Tarea editada con éxito!",

                            duration: 1500,
                            gravity: "top",
                            position: "right",
                            style: {
                                background: "linear-gradient(to right, #00b09b, #96c93d)",
                            },

                        }).showToast();

                        window.location.href = `/tasks/${data.id}`;
                    })
                    .catch(error => {
                        console.error(error.message);
                    });
            });
        });
    </script>
@endsection
