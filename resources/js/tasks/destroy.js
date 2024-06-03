function deleteTask(apiUrl, taskId, accessToken) {
    return fetch(`${apiUrl}/tasksAPI/${taskId}`, {
            method: 'DELETE',
            headers: {
                'Authorization': `Bearer ${accessToken}`,
            },
        })
        .then(response => {
            if (response.status === 204) {
                Toastify({
                    text: "¡Tarea eliminada con éxito!",
                    duration: 1000,
                    gravity: "top",
                    position: "right",
                    style: {
                        background: "linear-gradient(to right, #00b09b, #96c93d)",
                    },
                    callback: function () {
                        window.location.href = '/tasks';
                    }
                }).showToast();
            } else {
                return response.json().then(data => {
                    throw new Error(data.error || 'Error al borrar.');
                });
            }
        })
        .catch(error => {
            console.error(error.message);
        });
}

window.initializeDeleteTask = function (apiUrl, taskId, accessToken) {
    const deleteButton = document.getElementById('delete-task');
    deleteButton.addEventListener('click', function () {
        if (confirm('¿Estás seguro de que deseas eliminar esta tarea?')) {
            deleteTask(apiUrl, taskId, accessToken);
        }
    });
};
