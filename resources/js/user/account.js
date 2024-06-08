import {
    getUserInfo
} from "../utils/getUserInfo";
import {
    showToastWithCallback
} from "../utils/showToastWithCallback";
import {
    formatDate
} from "../utils/formatDate";

document.addEventListener('DOMContentLoaded', async function () {
    const userName = document.getElementById("name");
    const userUsername = document.getElementById("username");
    const userEmail = document.getElementById("email");
    const userBirthday = document.getElementById("birthday");
    const deleteButton = document.getElementById("delete-btn");

    const apiUrl = 'http://127.0.0.1:8000/api';
    const accessToken = localStorage.getItem('accessToken');

    const user = await getUserInfo(apiUrl, accessToken);

    try {

        userName.textContent = user.name;
        userUsername.textContent = user.username;
        userEmail.textContent = user.email;
        userBirthday.textContent = formatDate(user.birthday);

        deleteButton.addEventListener('click', function () {
            showConfirm(user.id);
        });
    } catch (error) {
        console.error('Error:', error);

    }

    async function getTasksUser() {
        try {
            const tasksResponse = await fetch(`${apiUrl}/users/${user.id}/tasks`, {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${accessToken}`,
                },
            });

            if (!tasksResponse.ok) {
                throw new Error('Error al obtener las tareas del usuario.');
            }

            const tasksData = await tasksResponse.json();
            console.log(tasksData);

            let scoresData = [];
            if (user.rol === 'participant') {
                const scoresResponse = await fetch(`${apiUrl}/scores/users/${user.id}`, {
                    method: 'GET',
                    headers: {
                        'Authorization': `Bearer ${accessToken}`,
                    },
                });

                if (!scoresResponse.ok) {
                    throw new Error('Error al obtener las puntuaciones del usuario.');
                }

                scoresData = await scoresResponse.json();
            }

            const tasksScoresDiv = document.getElementById('tasks-scores');
            tasksScoresDiv.innerHTML = '';

            if (user.rol !== 'admin') {
                const tasksScoresTitle = document.createElement('h2');

                if (user.rol === 'participant') {
                    tasksScoresTitle.textContent = 'Tus tareas';
                } else if (user.rol === 'supervisor') {
                    tasksScoresTitle.textContent = 'Tareas que supervisas';
                }

                tasksScoresTitle.classList.add('text-lg', 'font-bold', 'mb-3');
                tasksScoresDiv.appendChild(tasksScoresTitle);
            }

            if (user.rol.toLowerCase() !== 'admin') {
                if (tasksData.length === 0) {
                    const noTasksMessage = document.createElement('p');
                    noTasksMessage.classList.add('text-gray-500', 'text-sm', 'md:text-base');
                    noTasksMessage.textContent = 'No hay tareas disponibles.';
                    tasksScoresDiv.appendChild(noTasksMessage);
                } else {
                    const taskList = document.createElement('ol');
                    taskList.classList.add('list-decimal', 'pl-6', 'space-y-2', 'md:space-y-2', 'text-sm', 'md:text-base');

                    tasksData.forEach(task => {
                        const taskItem = document.createElement('li');
                        const taskName = document.createElement('span');
                        taskName.classList.add('font-bold');
                        taskName.textContent = task.name;
                        taskItem.appendChild(taskName);

                        if (user.rol === 'participant') {
                            const score = scoresData.find(score => score.task_id === task.id);
                            const scoreSpan = document.createElement('span');
                            scoreSpan.innerHTML = `- Puntuación: <span class="font-bold">${score ? score.points : 0}</span>`;
                            taskItem.appendChild(scoreSpan);
                        }

                        taskList.appendChild(taskItem);
                    });

                    tasksScoresDiv.appendChild(taskList);
                }
            }

            document.getElementById('task-list').appendChild(tasksScoresDiv);
        } catch (error) {
            console.error(error.message);
        }
    }



    async function deleteAccount(id) {
        try {
            const response = await fetch(`${apiUrl}/users/${id}`, {
                method: 'DELETE',
                headers: {
                    'Authorization': `Bearer ${accessToken}`,
                    'Content-Type': 'application/json'
                }
            });

            if (response.ok) {
                localStorage.removeItem('accessToken');
                showToastWithCallback("Cuenta eliminada con éxito", "linear-gradient(to right, #00b09b, #96c93d)", () => {
                    window.location.href = '/';
                });
            }
        } catch (error) {
            console.error(`Error inesperado al eliminar usuario: ${error}`);
        }
    }

    function showConfirm(userID) {
        $.confirm({
            title: '¿Seguro que quieres borrar tu cuenta?',
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
                    action: function () {}
                },
                confirm: {
                    text: 'Confirmar',
                    btnClass: 'btn-green',
                    action: async function () {
                        await deleteAccount(userID);
                    }
                },
            }
        });
    }

    getTasksUser();
});
