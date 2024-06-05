@extends('layout')

@section('title', 'Tarea')

@section('content')
    <div class="p-4">
        <div class="mb-4">
            <h1 class="text-2xl font-bold">Detalles de la Tarea</h1>
            <p>ID de la Tarea: {{ $task->id }}</p>
            <p>Nombre de la Tarea: {{ $task->name }}</p>
        </div>

        <div class="flex space-x-4 mb-4">
            <button class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded">
                <a href="{{ route('tasks.edit', $task->id) }}">Editar Tarea</a>
            </button>

            <button id="delete-task" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">
                Eliminar Tarea
            </button>
        </div>

        <div id="task-users" class="mb-4 p-4 bg-gray-100 rounded shadow-md">
        </div>

        <div class="mb-4 bg-green-200 rounded-md p-4">
            <label for="user-select" class="block text-gray-700 text-sm font-bold mb-2">Asignar nuevo usuario:</label>
            <select id="user-select"
                class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                <option value="">Seleccione un usuario</option>
            </select>
            <button id="assign-user"
                class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 mt-2 rounded">Asignar Usuario</button>
        </div>

        <div id="task-categories" class="mb-4 p-4 bg-blue-100 rounded shadow-md">
            <h2 class="text-xl font-bold mb-2">Categorías de la Tarea:</h2>
            <ul id="category-list" class="list-disc list-inside">

            </ul>
        </div>

        <div class="mb-4 bg-pink-200 rounded-md p-4">
            <label for="category-select" class="block text-gray-700 text-sm font-bold mb-2">Asignar nueva categoría:</label>
            <select id="category-select"
                class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                <option value="">Seleccione una categoría</option>
            </select>
            <button id="assign-category"
                class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 mt-2 rounded">Asignar Categoría</button>
        </div>

        <div id="user-scores" class="mb-4 p-4 bg-gray-200 rounded shadow-md">
            <h2 class="text-xl font-bold mb-2">Puntuaciones de los Usuarios</h2>
        </div>

    </div>
@endsection

@section('scripts')
    @vite('resources/js/tasks/users.js')
    @vite('resources/js/tasks/destroy.js')
    @vite('resources/js/categories/main.js')
    @vite('resources/js/scores/main.js')
    {{-- @vite('resources/js/categories/index.js')
    @vite('resources/js/categories/getFromTask.js')
    @vite('resources/js/categories/assignToTask.js') --}}

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const accessToken = localStorage.getItem('accessToken');
            const taskId = @json($task->id);
            let users = [];
            let categories = [];

            const apiUrl = 'http://127.0.0.1:8000/api';

            //PENSAR SI MODIFICAR EL DISEÑO DE LAS PUNTUACIONES





            function assignScoreToUser(userId) {
                const points = document.getElementById(`points-${userId}`).value;

                if (!points) {
                    alert('Por favor, asigne una puntuación.');
                    return;
                }

                return fetch(`${apiUrl}/scores`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            points: points,
                            user_id: userId,
                            task_id: taskId
                        }),
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(data => {
                                throw new Error(data.error || 'Error al asignar la puntuación.');
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        alert('Puntuación asignada correctamente.');
                        document.getElementById(`points-${userId}`).value = '';
                        fetchTaskUsers();
                    })
                    .catch(error => {
                        /* console.error(error.message); */
                    });
            }

            function makeEditable(userId, taskId) {
                console.log(0);
                const pointsElement = document.getElementById(`points-${userId}`);
                const oldPoints = pointsElement.textContent;
                pointsElement.innerHTML =
                    `<input type="number" id="points-input-${userId}" value="${oldPoints}" class="border border-gray-400 px-2 py-1 rounded">`;

                const editButton = pointsElement.nextSibling;
                editButton.textContent = 'Guardar';
                editButton.onclick = () => savePoints(userId, taskId);
            }

            function savePoints(userId) {
                const inputElement = document.getElementById(`points-input-${userId}`);
                const newPoints = inputElement.value;

                const method = inputElement.dataset.exists ? 'PATCH' : 'POST';

                fetch(`${apiUrl}/scores/${userId}/${taskId}`, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization': `Bearer ${accessToken}`,
                        },
                        body: JSON.stringify({
                            points: newPoints
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        const pointsElement = document.getElementById(`points-${userId}`);
                        pointsElement.textContent = data.points;

                        const editButton = document.querySelector(`#points-${userId} + button`);
                        editButton.textContent = 'Editar';
                        editButton.onclick = () => makeEditable(userId);
                    });
            }


            initializeDeleteTask(apiUrl, taskId, accessToken);

            initializeCategoryFunctions(apiUrl, taskId, categories, accessToken);

            initializeUserFunctions(apiUrl, taskId, users, accessToken);

            initializeScoreFunctions(apiUrl, taskId, accessToken);

            /* function toggleEditMode(userId) {
                console.log(1);
                const pointsDisplay = document.getElementById(`points-display-${userId}`);
                const pointsInput = document.getElementById(`points-input-${userId}`);
                const editButton = document.getElementById(`edit-button-${userId}`);

                if (pointsInput.classList.contains('hidden')) {
                    pointsDisplay.classList.add('hidden');
                    pointsInput.classList.remove('hidden');
                    editButton.textContent = 'Guardar';
                    editButton.onclick = () => saveScore(userId);
                } else {
                    pointsDisplay.classList.remove('hidden');
                    pointsInput.classList.add('hidden');
                    editButton.textContent = 'Editar';
                    editButton.onclick = () => toggleEditMode(userId);
                }
            }

            function saveScore(userId) {
                const pointsInput = document.getElementById(`points-input-${userId}`).value;

                return fetch(`${apiUrl}/scores/${userId}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            points: pointsInput,
                            user_id: userId,
                            task_id: taskId
                        }),
                    })
                    .then(response => response.json())
                    .then(data => {
                        alert('Puntuación guardada correctamente.');
                        fetchTaskUsers();
                    })
                    .catch(error => {
                        console.error(error.message);
                    });
            } */

            /* fetchTaskUsers();

            fetchAllUsers(); */


            /* initializeFetchTaskCategories(apiUrl, taskId, categories);
            initializeFetchAllCategories(apiUrl, categories);
            initializeAssignCategoryToTask(apiUrl, taskId, categories); */

            //initializeFetchTaskCategories(apiUrl, taskId, categories);
            //initializeFetchAllCategories(apiUrl, categories);



            /* assignButton.addEventListener('click', function() {
                assignUserToTask();
            }); */

        });
    </script>


@endsection
