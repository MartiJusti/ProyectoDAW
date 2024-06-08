document.addEventListener('DOMContentLoaded', async function () {
    const taskForm = document.getElementById('task-form');
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

    if (userRole === 'participant') {
        window.location.href = '/';
    }

    taskForm.addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(taskForm);
        fetch(`${apiUrl}/tasks`, {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${accessToken}`
                },
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(
                        'Datos de tarea incorrectos.');
                }
                return response.json();
            })
            .then(data => {
                taskForm.reset();

                Toastify({
                    text: "¡Tarea creada con éxito!",

                    duration: 1000,
                    gravity: "top",
                    position: "center",
                    style: {
                        background: "linear-gradient(to right, #00b09b, #96c93d)",
                    },
                    callback: function () {
                        window.location.href = '/tasks';
                    }

                }).showToast();
            })
            .catch(error => {
                /* console.error(error.message); */
            });
    });
});
