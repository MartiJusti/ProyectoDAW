const apiUrl = 'http://127.0.0.1:8000/api';

async function editTask(taskId, accessToken, userRole) {
    if (userRole === 'participant') {
        showToast('No tienes permisos para realizar esta acción.', 'linear-gradient(to right, #DB0202, #750000)');
        window.location.href = '/account';
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
                showToast("Tarea editada con éxito", "linear-gradient(to right, #00b09b, #96c93d)", data.id);
            }

        } catch (error) {
            console.error(error.message);
        }
    });
}

async function getUserRole(accessToken) {
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

function showToast(message, background, taskId) {
    Toastify({
        text: message,
        duration: 1250,
        gravity: "top",
        position: "center",
        style: {
            background: background,
        },
        callback: function () {
            window.location.href = `/tasks/${taskId}`;
        }
    }).showToast();

}

window.initializeEditTask = async function (taskId, accessToken) {
    const userRole = await getUserRole(accessToken);

    editTask(taskId, accessToken, userRole);
}
