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

    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButton = document.getElementById('delete-task');
            const assignButton = document.getElementById('assign-user');
            const assignCategoryButton = document.getElementById('assign-category');
            const accessToken = localStorage.getItem('accessToken');
            const taskId = @json($task->id);
            let users = [];
            let categories = [];

            const apiUrl = 'http://127.0.0.1:8000/api';

            //PENSAR SI MODIFICAR EL DISEÑO DE LAS PUNTUACIONES

            function fetchTaskUsers() {
                return fetch(`${apiUrl}/tasks/${taskId}/users`, {
                        method: 'GET',
                        /* headers: {
                            'Authorization': `Bearer ${accessToken}`,
                        }, */
                    })
                    .then(response => response.json())
                    .then(data => {
                        const taskUsers = document.getElementById("task-users");
                        taskUsers.innerHTML = '';
                        users = [];

                        if (data.length === 0) {
                            taskUsers.innerHTML = '<p>No hay usuarios asignados a esta tarea.</p>';
                        } else {
                            data.forEach(user => {
                                const userContainer = document.createElement('div');
                                userContainer.className = 'flex items-center mb-2';

                                const userElement = document.createElement('p');
                                userElement.textContent = user.name;
                                userElement.className = 'text-gray-700 mr-4';
                                userContainer.appendChild(userElement);

                                const pointsElement = document.createElement('span');
                                pointsElement.textContent = user.points ?? 0;
                                pointsElement.className = 'text-gray-700 mr-4';
                                pointsElement.id = `points-${user.id}`;
                                userContainer.appendChild(pointsElement);

                                const editButton = document.createElement('button');
                                editButton.textContent = 'Editar';
                                editButton.className =
                                    'bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-1 px-2 rounded mr-2';
                                editButton.onclick = () => makeEditable(user.id, user.task_id);
                                userContainer.appendChild(editButton);

                                const deleteButton = document.createElement('button');
                                deleteButton.textContent = 'Eliminar';
                                deleteButton.className =
                                    'bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-2 rounded';
                                deleteButton.onclick = () => deleteUserFromTask(user.id, taskId);
                                userContainer.appendChild(deleteButton);

                                taskUsers.appendChild(userContainer);
                                users.push(user);
                            });
                        }
                    });
            }

            function makeEditable(userId, taskId) {
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

                fetch(`${apiUrl}/scoresAPI/${userId}/${taskId}`, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            /* 'Authorization': `Bearer ${accessToken}`, */
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

            function deleteUserFromTask(userId, taskId) {
                if (confirm('¿Estás seguro de que deseas eliminar este usuario de la tarea?')) {
                    fetch(`${apiUrl}/tasks/${taskId}/users/${userId}`, {
                            method: 'DELETE',
                            /* headers: {
                                'Authorization': `Bearer ${accessToken}`,
                            }, */
                        })
                        .then(response => response.json())
                        .then(data => {
                            fetchTaskUsers();
                        });
                }
            }

            function fetchTaskCategories() {
                return fetch(`${apiUrl}/tasks/${taskId}/categories`, {
                        method: 'GET',
                        /* headers: {
                            'Authorization': `Bearer ${accessToken}`,
                        }, */
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Error al obtener las categorías de la tarea.');
                        }
                        return response.json();
                    })
                    .then(data => {
                        const categoryList = document.getElementById("category-list");
                        categoryList.innerHTML = '';
                        categories = [];

                        if (data.length === 0) {
                            categoryList.innerHTML = '<li>No hay categorías asignadas a esta tarea.</li>';
                        } else {
                            data.forEach(category => {
                                const listItem = document.createElement('li');
                                listItem.textContent = category.name;
                                listItem.className = 'text-gray-700';
                                categoryList.appendChild(listItem);

                                categories.push(category.id);
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error al obtener las categorías de la tarea:', error.message);
                    });
            }

            function fetchAllUsers() {
                return fetch(`${apiUrl}/usersAPI`, {
                        method: 'GET',
                        /* headers: {
                            'Authorization': `Bearer ${accessToken}`,
                        }, */
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Error al obtener los usuarios.');
                        }
                        return response.json();
                    })
                    .then(data => {
                        const userSelect = document.getElementById("user-select");
                        userSelect.innerHTML = '<option value="">Seleccione un usuario</option>';

                        const filteredUsers = data.filter(user => !user.rol.includes('supervisor') && !users
                            .includes(user.id));

                        filteredUsers.forEach(user => {
                            const option = document.createElement('option');
                            option.value = user.id;
                            option.textContent = user.name;
                            userSelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Error al obtener los usuarios:', error.message);
                    });
            }

            function fetchAllCategories() {
                return fetch(`${apiUrl}/categoriesAPI`, {
                        method: 'GET',
                        /* headers: {
                            'Authorization': `Bearer ${accessToken}`,
                        }, */
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Error al obtener las categorías.');
                        }
                        return response.json();
                    })
                    .then(data => {
                        const categorySelect = document.getElementById("category-select");
                        categorySelect.innerHTML = '<option value="">Seleccione una categoría</option>';

                        const filteredCategories = data.filter(category => !categories
                            .includes(category.id));

                        filteredCategories.forEach(category => {
                            const option = document.createElement('option');
                            option.value = category.id;
                            option.textContent = category.name;
                            categorySelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Error al obtener las categorías:', error.message);
                    });
            }

            function assignUserToTask() {
                const userId = document.getElementById('user-select').value;

                if (!userId) {
                    alert('Por favor, seleccione un usuario.');
                    return;
                }

                return fetch(`${apiUrl}/tasks/${taskId}/assign-user`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                            /* 'Authorization': `Bearer ${accessToken}`, */
                        },
                        body: JSON.stringify({
                            user_id: userId
                        }),
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(data => {
                                throw new Error(data.error || 'Error al asignar el usuario.');
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        alert('Usuario asignado correctamente.');
                        document.getElementById('user-select').value = '';

                        fetchTaskUsers();
                        fetchAllUsers();
                    })
                    .catch(error => {
                        console.error('Error al asignar el usuario:', error.message);
                    });
            }

            function assignCategoryToTask() {
                const categoryId = document.getElementById('category-select').value;

                if (!categoryId) {
                    alert('Por favor, seleccione una categoría.');
                    return;
                }

                return fetch(`${apiUrl}/tasks/${taskId}/assign-category`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                            /* 'Authorization': `Bearer ${accessToken}`, */
                        },
                        body: JSON.stringify({
                            category_id: categoryId
                        }),
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(data => {
                                throw new Error(data.error || 'Error al asignar la categoría.');
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        alert('Categoría asignada correctamente.');
                        document.getElementById('category-select').value = '';

                        fetchTaskCategories();
                        fetchAllCategories();

                    })
                    .catch(error => {
                        console.error('Error al asignar la categoría:', error.message);
                    });
            }

            function assignScoreToUser(userId) {
                const points = document.getElementById(`points-${userId}`).value;

                if (!points) {
                    alert('Por favor, asigne una puntuación.');
                    return;
                }

                return fetch(`${apiUrl}/scoresAPI`, {
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
                        console.error('Error al asignar la puntuación:', error.message);
                    });
            }

            function deleteTask() {
                return fetch(`${apiUrl}/tasksAPI/${taskId}`, {
                        method: 'DELETE',
                        headers: {
                            'Authorization': `Bearer ${accessToken}`,
                        },
                    })
                    .then(response => {
                        if (response.status === 204) {
                            window.location.href = '/tasks';
                        } else {
                            return response.json().then(data => {
                                throw new Error(data.error || 'Error al borrar.');
                            });
                        }
                    })
                    .catch(error => {
                        console.error(error.message);
                    });
            }

            function toggleEditMode(userId) {
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

                return fetch(`${apiUrl}/scoresAPI/${userId}`, {
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
                        console.error('Error al guardar la puntuación:', error.message);
                    });
            }

            fetchTaskUsers();
            fetchTaskCategories();
            fetchAllUsers();
            fetchAllCategories();

            deleteButton.addEventListener('click', function() {
                if (confirm('¿Estás seguro de que deseas eliminar esta tarea?')) {
                    deleteTask();
                }
            });

            assignButton.addEventListener('click', function() {
                assignUserToTask();
            });

            assignCategoryButton.addEventListener('click', function() {
                assignCategoryToTask();
            });
        });
    </script>
@endsection
