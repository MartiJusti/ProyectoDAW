import {
    getUserInfo
} from "../utils/getUserInfo";
import {
    showToast
} from "../utils/showToast";

const scoreState = {};

async function fetchTaskUsersAndScores(apiUrl, taskId, users, accessToken, userRole) {

    try {
        const usersResponse = await fetch(`${apiUrl}/tasks/${taskId}/users`, {
            method: 'GET',
            headers: {
                'Authorization': `Bearer ${accessToken}`
            }
        });

        if (!usersResponse.ok) {
            throw new Error('Error al obtener los usuarios de la tarea.');
        }

        const usersData = await usersResponse.json();

        const scoresResponse = await fetch(`${apiUrl}/scores/tasks/${taskId}`, {
            method: 'GET',
            headers: {
                'Authorization': `Bearer ${accessToken}`
            }
        });

        if (!scoresResponse.ok) {
            throw new Error('Error al obtener las puntuaciones de la tarea.');
        }

        const scoresData = await scoresResponse.json();

        const taskUsers = document.getElementById("task-users");
        const scoresContainer = document.getElementById("scores");
        taskUsers.innerHTML = '';
        users.length = 0;
        console.log(usersData);
        if (usersData.length === 0 || (usersData.length === 1 && usersData.rol !== 'participant')) {

            scoresContainer.classList.add('flex');
            taskUsers.classList.add('m-auto');
            taskUsers.classList.remove('shadow-md');
            taskUsers.innerHTML = `<span class="flex flex-col items-center justify-center text-gray-400 shadow-none">
                                    No hay usuarios asignados a esta tarea.</span>`;

        } else {
            scoresContainer.classList.remove('flex');
            taskUsers.classList.remove('m-auto');
            taskUsers.classList.add('shadow-md');

            const table = document.createElement('table');
            table.className = 'table-auto w-full border-collapse border border-gray-400 rounded-2xl';

            const tableBody = document.createElement('tbody');
            const participantUsers = usersData.filter(user => user.rol === 'participant');

            const combinedData = participantUsers.map(user => {
                const userScore = scoresData.find(score => score.user.id === user.id);

                scoreState[user.id] = {
                    points: userScore ? userScore.points : 0,
                    exists: !!userScore
                };
                return {
                    ...user,
                    points: scoreState[user.id].points
                };
            });

            combinedData.sort((a, b) => {
                if (b.points === a.points) {
                    return a.username.localeCompare(b.username);
                }
                return b.points - a.points;
            });

            combinedData.forEach((user, index) => {
                const tableRow = document.createElement('tr');

                switch (index) {
                    case 0:
                        tableRow.className = 'bg-yellow-400';
                        break;
                    case 1:
                        tableRow.className = 'bg-zinc-300';
                        break;
                    case 2:
                        tableRow.className = 'bg-yellow-700';
                        break;
                }

                tableRow.innerHTML = `
                    <td class="px-4 py-2 border border-gray-400 text-center font-bold">${index + 1}º</td>
                    <td class="px-4 py-2 border border-gray-400 text-center font-bold">${user.username}</td>
                    <td class="px-4 py-2 border border-gray-400 text-center font-bold">
                        <span id="points-${user.id}">${user.points}</span>
                        <input type="number" id="points-input-${user.id}" value="${user.points}" class="hidden w-8 md:w-1/4" />
                    </td>
                    ${userRole !== 'participant' ? `
                        <td id="buttons-${user.id}" class="px-4 py-2 border border-gray-400 text-center md:grid">
                            <button id="edit-btn-${user.id}" class="transition-all duration-300 ease-in-out hover:scale-125 rounded-2xl" title="Editar">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button id="delete-btn-${user.id}" class="transition-all duration-300 ease-in-out hover:scale-125 rounded-2xl" title="Eliminar">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    ` : ''}
                `;

                tableBody.appendChild(tableRow);
            });

            table.appendChild(tableBody);
            taskUsers.appendChild(table);

            users.push(...usersData);

            taskUsers.style.maxHeight = '200px';
            taskUsers.style.overflowY = 'scroll';

            combinedData.forEach(user => {

                const deleteButton = document.getElementById(`delete-btn-${user.id}`);
                deleteButton.addEventListener('click', async () => {
                    showConfirm(apiUrl, user.id, taskId, users, accessToken);

                });

                const editButton = document.getElementById(`edit-btn-${user.id}`);
                editButton.addEventListener('click', () => {
                    makeEditable(apiUrl, accessToken, user.id, taskId);

                });
            });

        }
    } catch (error) {
        console.error(error.message);
    }
}

async function savePoints(apiUrl, accessToken, userId, taskId) {
    const inputElement = document.getElementById(`points-input-${userId}`);
    const newPoints = inputElement.value;
    const scoreExists = scoreState[userId].exists;
    const method = scoreExists ? 'PATCH' : 'POST';

    try {
        const response = await fetch(`${apiUrl}/scores/${userId}/${taskId}`, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${accessToken}`,
            },
            body: JSON.stringify({
                points: newPoints
            })
        });

        if (!response.ok) {
            throw new Error('Error al guardar la puntuación.');
        }

        const data = await response.json();

        scoreState[userId] = {
            points: data.points,
            exists: true
        };

        const pointsElement = document.getElementById(`points-${userId}`);
        pointsElement.textContent = data.points;

        inputElement.classList.add('hidden');
        pointsElement.classList.remove('hidden');

        const editButton = document.getElementById(`edit-btn-${userId}`);
        editButton.innerHTML = '<i class="fas fa-edit"></i>';
        editButton.onclick = () => makeEditable(apiUrl, accessToken, userId, taskId);

        showToast("Puntuación guardada correctamente", "linear-gradient(to right, #00b09b, #96c93d)");

        await fetchTaskUsersAndScores(apiUrl, taskId, [], accessToken);

    } catch (error) {
        console.error(error.message);
    }
}

function makeEditable(apiUrl, accessToken, userId, taskId) {
    const pointsElement = document.getElementById(`points-${userId}`);
    const inputElement = document.getElementById(`points-input-${userId}`);
    const editButton = document.getElementById(`edit-btn-${userId}`);

    pointsElement.classList.add('hidden');
    inputElement.classList.remove('hidden');

    editButton.innerHTML = '<i class="fas fa-check"></i>';
    editButton.onclick = () => savePoints(apiUrl, accessToken, userId, taskId);
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

        const filteredUsers = data.filter(user => !users.some(u => u.id === user.id) && !user.rol.includes('supervisor') && !user.rol.includes('admin'));

        filteredUsers.forEach(user => {
            const option = document.createElement('option');
            option.value = user.id;
            option.textContent = user.username;
            userSelect.appendChild(option);
        });
    } catch (error) {
        console.error(error.message);
    }
}


async function assignUserToTask(apiUrl, taskId, users, accessToken, userRole) {
    if (userRole === 'participant') {
        showToast('No tienes permisos para realizar esta acción.', 'linear-gradient(to right, #DB0202, #750000)');
        return;
    }

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

        await fetchTaskUsersAndScores(apiUrl, taskId, users, accessToken);
        await fetchAllUsers(apiUrl, users, accessToken);
    } catch (error) {
        console.error(error.message);
    }
}

async function deleteUserFromTask(apiUrl, userId, taskId, users, accessToken) {

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

        await fetchTaskUsersAndScores(apiUrl, taskId, users, accessToken);
        await fetchAllUsers(apiUrl, users, accessToken);
    } catch (error) {
        console.error(error.message);
    }
}

window.initializeUserAndScoreFunctions = async function (apiUrl, taskId, users, accessToken) {
    const userInfo = await getUserInfo(apiUrl, accessToken);

    const categoriesDiv = document.getElementById('categories');
    const usersDiv = document.getElementById('users');
    const supervisorPanel = document.getElementById('supervisor-panel');
    const taskInfo = document.getElementById('task-info');
    const scores = document.getElementById('scores');
    const mainContainer = document.getElementById('main-container');

    /* Este código es para ocultar los elementos de supervisor y
    organizar los contenedores */
    if (userInfo.rol.toLocaleLowerCase() === 'participant') {
        categoriesDiv.classList.add('hidden');
        usersDiv.classList.add('hidden');
        supervisorPanel.classList.add('hidden');

        taskInfo.classList.add('order-1', 'md:order-1');
        taskInfo.classList.remove('md:w-2/5');
        taskInfo.classList.add('md:w-1/2');
        taskInfo.classList.add('md:m-auto');
        scores.classList.add('order-2', 'md:order-2');
        scores.classList.remove('md:w-2/5');
        scores.classList.add('md:w-1/2');
        scores.classList.add('md:m-auto');
        mainContainer.classList.add('flex-col');
    } else {
        categoriesDiv.classList.remove('hidden');
        usersDiv.classList.remove('hidden');
        supervisorPanel.classList.remove('hidden');

        taskInfo.classList.remove('order-1', 'md:order-1');
        taskInfo.classList.add('md:w-2/5');
        taskInfo.classList.remove('md:w-1/2');
        taskInfo.classList.remove('md:m-auto');
        scores.classList.remove('order-2', 'md:order-2');
        scores.classList.add('md:w-2/5');
        scores.classList.remove('md:w-1/2');
        scores.classList.remove('md:m-auto');
        mainContainer.classList.remove('flex-col');
    }

    //Esto es para que fetchAllUsers actúe después de fetchTaskUsersAndScores para poder filtrar los usuarios en el desplegable
    fetchTaskUsersAndScores(apiUrl, taskId, users, accessToken, userInfo.rol).then(() => {
        fetchAllUsers(apiUrl, users, accessToken);
    });

    const assignButton = document.getElementById('assign-user');
    assignButton.addEventListener('click', function () {
        assignUserToTask(apiUrl, taskId, users, accessToken, userInfo.rol);
    });
};

function showConfirm(apiUrl, userId, taskId, users, accessToken) {
    $.confirm({
        title: '¿Seguro que quieres eliminar a este usuario de la tarea?',
        content: 'La acción es irreversible.',
        type: 'red',
        boxWidth: '60%',
        useBootstrap: false,
        icon: 'fa fa-warning',
        closeIcon: true,
        closeIconClass: 'fa fa-close',
        animateFromElement: false,
        animation: 'scale',
        backgroundDismiss: false,
        backgroundDismissAnimation: 'shake',
        buttons: {
            cancel: {
                text: 'Cancelar',
                btnClass: 'btn-red',
                action: function () {

                }
            },
            confirm: {
                text: 'Confirmar',
                btnClass: 'btn-green',
                action: async function () {
                    await deleteUserFromTask(apiUrl, userId, taskId, users, accessToken);
                }
            },
        }
    });
}
