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
    const usernameInput = document.getElementById('username');

    const apiUrl = 'http://127.0.0.1:8000/api';
    const accessToken = localStorage.getItem('accessToken');

    try {
        const user = await getUserInfo(apiUrl, accessToken);
        usernameInput.value = user.username;

        const editForm = document.getElementById('edit-account-form');
        editForm.addEventListener('submit', async function (e) {
            e.preventDefault();
            clearErrors();

            const formData = new FormData(editForm);
            const userData = {};

            //Para que no envíe el dato de un campo vacío
            if (formData.has('username') && formData.get('username').trim() !== '') {
                userData.username = formData.get('username');
            }

            if (formData.has('password') && formData.get('password').trim() !== '') {
                userData.password = formData.get('password');
            }

            formData.forEach((value, key) => {
                userData[key] = value;
            });

            await editUser(user.id, userData);
        });
    } catch (error) {
        console.error('Error:', error);

    }

    async function editUser(userId, userData) {

        try {
            const response = await fetch(`${apiUrl}/users/${userId}`, {
                method: 'PATCH',
                headers: {
                    'Authorization': `Bearer ${accessToken}`,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(userData)
            });

            const data = await response.json();

            if (!response.ok) {
                throw new Error(JSON.stringify(data));
            }

            if (data) {
                showToastWithCallback("Usuario editado con éxito", "linear-gradient(to right, #00b09b, #96c93d)", () => {
                    window.location.href = '/account';
                });
            }
        } catch (error) {
            try {
                const errorData = JSON.parse(error.message);
                displayErrors(errorData.errors);
            } catch (e) {
                console.error('Error:', error.message);
            }
        }
    }
});
