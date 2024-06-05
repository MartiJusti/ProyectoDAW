
async function fetchTaskUsers(apiUrl, taskId, users, accessToken) {
    try {
        const response = await fetch(`${apiUrl}/tasks/${taskId}/users`, {
            method: 'GET',
            headers: {
                'Authorization': `Bearer ${accessToken}`
            }
        });

        if (!response.ok) {
            throw new Error('Error al obtener los usuarios de la tarea.');
        }

        const data = await response.json();
        const taskUsers = document.getElementById("task-users");
        taskUsers.innerHTML = '';
        users.length = 0;

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
                deleteButton.onclick = () => deleteUserFromTask(apiUrl, user.id, taskId, users);
                userContainer.appendChild(deleteButton);

                taskUsers.appendChild(userContainer);
                users.push(user);
            });
        }
    } catch (error) {
        /* console.error(error.message); */
    }
}

async function deleteUserFromTask(apiUrl, userId, taskId, users, accessToken) {
    if (confirm('¿Estás seguro de que deseas eliminar este usuario de la tarea?')) {
        try {
            const response = await fetch(`${apiUrl}/tasks/${taskId}/users/${userId}`, {
                method: 'DELETE',
                headers: {
                    'Authorization': `Bearer ${accessToken}`
                }
            });

            if (!response.ok) {
                throw new Error('Error al eliminar el usuario de la tarea.');
            }

            showToast("Se ha eliminado al usuario de la tarea correctamente", "linear-gradient(to right, #00b09b, #96c93d)");

            await fetchTaskUsers(apiUrl, taskId, users);
            await fetchAllUsers(apiUrl, users);
        } catch (error) {
            /* console.error(error.message); */
        }
    }
}

async function fetchAllUsers(apiUrl, users, accessToken) {
    try {
        const response = await fetch(`${apiUrl}/users`, {
            method: 'GET',
            headers: {
                'Authorization': `Bearer ${accessToken}`
            }
        });

        if (!response.ok) {
            throw new Error('Error al obtener los usuarios.');
        }

        const data = await response.json();
        const userSelect = document.getElementById("user-select");
        userSelect.innerHTML = '<option value="">Seleccione un usuario</option>';

        const filteredUsers = data.filter(user => !user.rol.includes('supervisor') && !users.some(u => u.id === user.id));

        filteredUsers.forEach(user => {
            const option = document.createElement('option');
            option.value = user.id;
            option.textContent = user.name;
            userSelect.appendChild(option);
        });
    } catch (error) {
        /* console.error(error.message); */
    }
}

async function assignUserToTask(apiUrl, taskId, users, accessToken) {
    const userId = document.getElementById('user-select').value;

    if (!userId) {
        showToast("Por favor, selecciona un usuario", "linear-gradient(to right, #DB0202, #750000)");
        return;
    }

    try {
        const response = await fetch(`${apiUrl}/tasks/${taskId}/assign-user`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${accessToken}`

            },
            body: JSON.stringify({
                user_id: userId
            }),
        });

        if (!response.ok) {
            const data = await response.json();
            throw new Error(data.error || 'Error al asignar el usuario.');
        }

        showToast("Usuario asignado correctamente", "linear-gradient(to right, #00b09b, #96c93d)");

        document.getElementById('user-select').value = '';

        await fetchTaskUsers(apiUrl, taskId, users);
        await fetchAllUsers(apiUrl, users);

    } catch (error) {
        /* console.error(error.message); */
    }
}

function showToast(message, background) {
    Toastify({
        text: message,
        duration: 2000,
        gravity: "top",
        position: "right",
        style: {
            background: background,
        }
    }).showToast();
}

window.initializeUserFunctions = function (apiUrl, taskId, users, accessToken) {
    fetchTaskUsers(apiUrl, taskId, users, accessToken);
    fetchAllUsers(apiUrl, users, accessToken);

    const assignButton = document.getElementById('assign-user');
    assignButton.addEventListener('click', function () {
        assignUserToTask(apiUrl, taskId, users, accessToken);
    });
};
