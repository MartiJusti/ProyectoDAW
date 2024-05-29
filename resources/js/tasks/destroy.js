export function deleteTask(accessToken, taskId) {
    const apiUrl = 'http://127.0.0.1:8000/api/tasksAPI/';

    fetch(`${apiUrl}${taskId}`, {
            method: 'DELETE',
            headers: {
                'Authorization': `Bearer ${accessToken}`,
            },
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al borrar.');
            }
            return response.json();
        })
        .then(data => {
            Toastify({
                text: "¡Tarea eliminada con éxito!",

                duration: 1500,
                gravity: "top",
                position: "right",
                style: {
                    background: "linear-gradient(to right, #f53527, #eed959)",
                },
                onClose: () => {
                    window.location.href = '/tasks';
                }

            }).showToast();

            window.location.href = '/tasks';
        })
        .catch(error => {
            console.error(error.message);
        });
}
