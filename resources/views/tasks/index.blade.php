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

                                const title = document.createElement('h2');
                                title.classList.add('text-lg', 'font-semibold', 'mb-2');
                                title.textContent = task.name;

                                const dateSection = document.createElement('div');
                                dateSection.classList.add('flex', 'items-center', 'justify-between',
                                    'mt-4');

                                const startDate = document.createElement('span');
                                startDate.classList.add('text-sm', 'text-gray-500');
                                startDate.textContent = `Inicio: ${task.date_start}`;
                                dateSection.appendChild(startDate);

                                const endDate = document.createElement('span');
                                endDate.classList.add('text-sm', 'text-gray-500');
                                endDate.textContent = `Fin: ${task.date_end}`;
                                dateSection.appendChild(endDate);

                                taskLink.appendChild(title);
                                taskLink.appendChild(dateSection);

                                card.appendChild(taskLink);
                                taskList.appendChild(card);
                            });
                        })
                        .catch(error => {
                            console.error('Error al obtener las tareas:', error);
                        });
                })
                .catch(error => {
                    console.error('Error al obtener información del usuario:', error);
                });
        });
    </script>
@endsection
