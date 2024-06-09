import {
    getUserInfo
} from "../utils/getUserInfo";
import {
    showToast
} from "../utils/showToast";
import {
    displayErrors,
    clearErrors
} from '../utils/errorHandling.js';

document.addEventListener('DOMContentLoaded', async function () {
    const categoryForm = document.getElementById('category-form');
    const accessToken = localStorage.getItem('accessToken');
    const apiUrl = 'http://127.0.0.1:8000/api';

    const userInfo = await getUserInfo(apiUrl, accessToken);

    if (userInfo.rol === 'participant') {
        window.location.href = '/';
    }

    categoryForm.addEventListener('submit', function (e) {
        e.preventDefault();
        clearErrors();

        const formData = new FormData(categoryForm);
        fetch(`${apiUrl}/categories`, {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${accessToken}`,
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
                categoryForm.reset();

                showToast('Categoría creada con éxito', 'linear-gradient(to right, #00b09b, #96c93d)');
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
});
