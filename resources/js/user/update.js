import {
    showToastWithCallbackAndId
} from "../utils/showToastWithCallbackAndId";
import {
    displayErrors,
    clearErrors
} from '../utils/errorHandling.js';

async function editUser(userId, accessToken) {
    const userForm = document.getElementById('edit-user-form');
    const apiUrl = 'http://127.0.0.1:8000/api';

    userForm.addEventListener('submit', async function (e) {
        e.preventDefault();
        clearErrors();

        const formData = new FormData(userForm);
        const jsonData = {};

        formData.forEach((value, key) => {
            jsonData[key] = value;
        });

        try {
            const response = await fetch(`${apiUrl}/users/${userId}`, {
                method: 'PATCH',
                headers: {
                    'Authorization': `Bearer ${accessToken}`,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(jsonData)
            });

            const data = await response.json();

            if (!response.ok) {
                throw new Error(JSON.stringify(data));
            }

            if (data) {
                showToastWithCallbackAndId("Usuario editado con éxito", "linear-gradient(to right, #00b09b, #96c93d)", "users", data.id);
            }

        } catch (error) {
            try {
                const errorData = JSON.parse(error.message);
                displayErrors(errorData.errors);
            } catch (e) {
                console.error('Error:', error.message);
            }
        }
    });
}

window.intializeEditUser = function (userId, accessToken) {
    editUser(userId, accessToken);
}
