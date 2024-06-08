import {
    showToastWithCallbackAndId
} from "../utils/showToastWithCallbackAndId";

async function editUser(userId, accessToken) {
    const userForm = document.getElementById('edit-user-form');
    const apiUrl = 'http://127.0.0.1:8000/api';

    userForm.addEventListener('submit', async function (e) {
        e.preventDefault();

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
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(jsonData)
            });

            const data = await response.json();

            if (data) {
                showToastWithCallbackAndId("Usuario editado con éxito", "linear-gradient(to right, #00b09b, #96c93d)", "users", data.id);
            }

        } catch (error) {
            console.error(error.message);
        }
    });
}

window.intializeEditUser = function(userId, accessToken) {
    editUser(userId, accessToken);
}
