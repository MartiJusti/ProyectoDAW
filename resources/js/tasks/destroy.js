function deleteTask(apiUrl, taskId, accessToken) {
    return fetch(`${apiUrl}/tasks/${taskId}`, {
            method: 'DELETE',
            headers: {
                'Authorization': `Bearer ${accessToken}`,
            },
        })
        .then(response => {
            if (response.status === 204) {
                showToast("Tarea eliminada con éxito", "linear-gradient(to right, #00b09b, #96c93d)");
            } else {
                return response.json().then(data => {
                    throw new Error(data.error || 'Error al borrar.');
                });

            }
        })
        .catch(error => {
            /* console.error(error.message); */
        });
}

function showToast(message, background) {
    Toastify({
        text: message,
        duration: 1500,
        gravity: "top",
        position: "right",
        style: {
            background: background,
        },
        callback: function () {
            window.location.href = '/tasks';
        }
    }).showToast();
}

window.initializeDeleteTask = function (apiUrl, taskId, accessToken) {
    const deleteButton = document.getElementById('delete-task');
    deleteButton.addEventListener('click', function () {
        if (confirm('¿Estás seguro de que deseas eliminar esta tarea?')) {
            deleteTask(apiUrl, taskId, accessToken);
        }
    });
};
