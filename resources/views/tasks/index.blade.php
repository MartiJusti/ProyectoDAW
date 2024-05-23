@extends('layout')

@section('title', 'Tareas')

@section('content')
    <div class="container mx-auto">
        <h1 class="text-3xl font-bold mt-8 mb-4">Listado de Tareas</h1>

        <div id="task-list" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div
                class="bg-gray-200 p-4 rounded-md shadow-md hover:shadow-lg transition duration-300 ease-in-out transform hover:scale-105 cursor-pointer">
                <div class="flex items-center justify-between mb-2">
                    <h2 class="text-lg font-semibold">Nombre de la Tarea</h2>
                    <span class="bg-blue-500 text-white px-2 py-1 rounded-full text-xs">ID: 1</span>
                </div>
                <p class="text-sm text-gray-700">Descripción de la tarea...</p>
                <div class="flex items-center justify-between mt-4">
                    <span class="text-sm text-gray-500">Fecha de inicio: 2024-05-08</span>
                    <span class="text-sm text-gray-500">Fecha de fin: 2024-05-15</span>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const taskList = document.getElementById('task-list');
        const accessToken = localStorage.getItem('accessToken');

        const apiUrl = 'http://127.0.0.1:8000/api/currentUser';

        fetch(apiUrl, {
            headers: {
                'Authorization': `Bearer ${accessToken}`
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al obtener información del usuario');
            }
            return response.json();
        })
        .then(user => {
            fetch(`http://127.0.0.1:8000/api/users/${user.id}/tasks`, {
                headers: {
                    'Authorization': `Bearer ${accessToken}`
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error al obtener las tareas');
                }
                return response.json();
            })
            .then(data => {
                taskList.innerHTML = '';

                data.forEach(task => {
                    const card = document.createElement('div');
                    card.classList.add('bg-gray-200', 'p-4', 'rounded-md', 'shadow-md',
                        'hover:shadow-lg', 'transition', 'duration-300',
                        'ease-in-out',
                        'transform', 'hover:scale-105', 'cursor-pointer');

                    const taskLink = document.createElement('a');
                    taskLink.href = `/tasks/${task.id}`;
                    taskLink.classList.add('w-full', 'h-full', 'block');
                    taskLink.addEventListener('click', (e) => {
                        e.stopPropagation();
                    });

                    const header = document.createElement('div');
                    header.classList.add('flex', 'items-center', 'justify-between',
                        'mb-2');

                    const title = document.createElement('h2');
                    title.classList.add('text-lg', 'font-semibold');
                    title.textContent = task.name;
                    header.appendChild(title);

                    const idTag = document.createElement('span');
                    idTag.classList.add('bg-blue-500', 'text-white', 'px-2', 'py-1',
                        'rounded-full',
                        'text-xs');
                    idTag.textContent = `ID: ${task.id}`;
                    header.appendChild(idTag);

                    taskLink.appendChild(header);

                    const description = document.createElement('p');
                    description.classList.add('text-sm', 'text-gray-700');
                    description.textContent = task.description;
                    taskLink.appendChild(description);

                    const dateSection = document.createElement('div');
                    dateSection.classList.add('flex', 'items-center', 'justify-between',
                        'mt-4');

                    const startDate = document.createElement('span');
                    startDate.classList.add('text-sm', 'text-gray-500');
                    startDate.textContent = `Fecha de inicio: ${task.date_start}`;
                    dateSection.appendChild(startDate);

                    const endDate = document.createElement('span');
                    endDate.classList.add('text-sm', 'text-gray-500');
                    endDate.textContent = `Fecha de fin: ${task.date_end}`;
                    dateSection.appendChild(endDate);

                    taskLink.appendChild(dateSection);

                    card.appendChild(taskLink);
                    taskList.appendChild(card);
                });
            })
            .catch(error => {
                console.error(error);
            });
        })
        .catch(error => {
            console.error('Error al obtener información del usuario:', error);
        });
    });
</script>
@endsection
