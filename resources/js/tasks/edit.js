import {
    getUserInfo
} from "../utils/getUserInfo";
import {
    showToastWithCallback
} from "../utils/showToastWithCallback";
import {
    showToastWithCallbackAndId
} from "../utils/showToastWithCallbackAndId";

const apiUrl = 'http://127.0.0.1:8000/api';

async function editTask(taskId, accessToken, userRole) {
    if (userRole === 'participant') {
        showToastWithCallback('No tienes permisos para realizar esta acción.', 'linear-gradient(to right, #DB0202, #750000)', () => {
            window.location.href = '/';
        });

        return;
    }

    const taskForm = document.getElementById('task-form');

    taskForm.addEventListener('submit', async function (e) {
        e.preventDefault();

        const formData = new FormData(taskForm);
        const jsonData = {};

        formData.forEach((value, key) => {
            jsonData[key] = value;
        });

        try {
            const response = await fetch(`${apiUrl}/tasks/${taskId}`, {
                method: 'PATCH',
                headers: {
                    'Authorization': `Bearer ${accessToken}`,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(jsonData)
            });

            const data = await response.json();

            if (data) {
                showToastWithCallbackAndId("Tarea editada con éxito", "linear-gradient(to right, #00b09b, #96c93d)", "tasks", data.id);
            }

        } catch (error) {
            console.error(error.message);
        }
    });
}

window.initializeEditTask = async function (taskId, accessToken) {
    const userInfo = await getUserInfo(apiUrl, accessToken);

    editTask(taskId, accessToken, userInfo.rol);
}
