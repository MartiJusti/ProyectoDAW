document.addEventListener('DOMContentLoaded', async function () {

    const accessToken = localStorage.getItem('accessToken');
    const apiUrl = 'http://127.0.0.1:8000/api';

    async function getUserRole(apiUrl, accessToken) {
        try {
            const response = await fetch(`${apiUrl}/currentUser`, {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${accessToken}`
                }
            });

            if (!response.ok) {
                throw new Error('Error al obtener la información del usuario.');
            }

            const data = await response.json();
            console.log(data.rol);
            return data.rol;
        } catch (error) {
            console.error(error.message);
            return null;
        }
    }

    const userRole = await getUserRole(apiUrl, accessToken);

    const registerForm = document.getElementById('register-form');
    const registerTitle = document.getElementById('register-title');
    const registerButton = document.getElementById('register-button');
    const rolSelect = document.getElementById('rol-select');

    if (accessToken && userRole.toLowerCase() !== 'admin') {
        window.location.href = "/";
    }

    if (accessToken && userRole.toLowerCase() === 'admin') {
        registerTitle.textContent = 'Crear cuenta';
        registerButton.textContent = 'Crear cuenta';
    }

    if (!accessToken || userRole.toLowerCase() !== 'admin') {
        rolSelect.classList.add('hidden');
    }

    registerForm.addEventListener('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(registerForm);

        fetch(`${apiUrl}/register`, {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(
                        'Usuario no autorizado. Por favor, verifique sus credenciales.');
                }
                return response.json();
            })
            .then(data => {
                showToast("Cuenta creada con éxito", "linear-gradient(to right, #00b09b, #96c93d)");
                registerForm.reset();
            })
            .catch(error => {
                /* console.error(error.message); */

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
