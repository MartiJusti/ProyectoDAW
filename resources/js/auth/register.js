import {
    getUserInfo
} from "../utils/getUserInfo";
import {
    displayErrors,
    clearErrors
} from '../utils/errorHandling.js';

document.addEventListener('DOMContentLoaded', async function () {

    const accessToken = localStorage.getItem('accessToken');
    const apiUrl = 'http://127.0.0.1:8000/api';

    const userInfo = await getUserInfo(apiUrl, accessToken);

    const registerForm = document.getElementById('register-form');
    const rolSelect = document.getElementById('rol-select');

    if (accessToken && userInfo && userInfo.rol.toLowerCase() !== 'admin') {
        window.location.href = "/";
    }

    if (accessToken && userInfo && userInfo.rol.toLowerCase() === 'admin') {

        rolSelect.innerHTML = `<label for="role" class="sr-only">Rol</label>
        <select id="role" name="rol"
            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 text-sm">
            <option value="" disabled selected>Selecciona un rol</option>
            <option value="supervisor">Supervisor</option>
            <option value="participant">Participante</option>
        </select>`;
    }

    if (!accessToken || userInfo.rol.toLowerCase() !== 'admin') {
        rolSelect.classList.add('hidden');
    } else {
        rolSelect.classList.remove('hidden');
    }

    registerForm.addEventListener('submit', function (e) {
        e.preventDefault();
        clearErrors();

        const formData = new FormData(registerForm);

        fetch(`${apiUrl}/register`, {
                method: 'POST',
                headers: {
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
                showToast("Cuenta creada con éxito", "linear-gradient(to right, #00b09b, #96c93d)");
                registerForm.reset();
            })
            .catch(error => {
                try {
                    const errorData = JSON.parse(error.message);
                    displayErrors(errorData.errors);
                } catch (e) {
                    console.error('Error:', error.message);
                }

            });
    });

    function showToast(message, background) {
        Toastify({
            text: message,
            duration: 1000,
            gravity: "top",
            position: "center",
            style: {
                background: background,
            },
            callback: function () {
                if (!accessToken) {
                    window.location.href = '/login';
                }
            }
        }).showToast();
    }
});
