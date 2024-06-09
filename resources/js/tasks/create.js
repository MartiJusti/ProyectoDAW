import {
    getUserInfo
} from "../utils/getUserInfo";
import {
    showToastWithCallback
} from "../utils/showToastWithCallback";
import {
    displayErrors,
    clearErrors
} from '../utils/errorHandling.js';

document.addEventListener('DOMContentLoaded', async function () {
    const taskForm = document.getElementById('task-form');
    const accessToken = localStorage.getItem('accessToken');
    const apiUrl = 'http://127.0.0.1:8000/api';

    const userInfo = await getUserInfo(apiUrl, accessToken);

    if (userInfo.rol === 'participant') {
        window.location.href = '/';
    }

    taskForm.addEventListener('submit', function (e) {
        e.preventDefault();
        clearErrors();

        const formData = new FormData(taskForm);
        fetch(`${apiUrl}/tasks`, {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${accessToken}`,
                    /* Se añade el siguiente parámetro para que devuelva
                    los errores de validación en formato JSON y
                    se puedan mostrar en pantalla */
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(async response => {
                if (!response.ok) {
                    let errorData;

                    try {
                        errorData = await response.json();
                    } catch (e) {
                        const errorText = await response.text();
                        throw new Error(errorText);
                    }
                    throw new Error(JSON.stringify(errorData));
                }
                return response.json();
            })
            .then(data => {
                taskForm.reset();

                showToastWithCallback('Tarea creada con éxito', 'linear-gradient(to right, #00b09b, #96c93d)', () => {
                    window.location.href = '/tasks';
                });
            })
            .catch(error => {
                try {
                    const errorData = JSON.parse(error.message);
                    displayErrors(errorData.errors);
                } catch (e) {
                    /* console.error('Error:', error.message); */
                }
            });
    });
});
