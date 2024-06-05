async function editTask(taskId, accessToken) {
    const taskForm = document.getElementById('task-form');
    const apiUrl = 'http://127.0.0.1:8000/api';

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

function showToast(message, background, taskId) {
    Toastify({
        text: message,
        duration: 1250,
        gravity: "top",
        position: "right",
        style: {
            background: background,
        },
        callback: function () {
            window.location.href = `/tasks/${taskId}`;
        }
    }).showToast();

}

window.initializeEditTask = function(taskId, accessToken) {
    editTask(taskId, accessToken);
}
