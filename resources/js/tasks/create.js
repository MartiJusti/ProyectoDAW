document.addEventListener('DOMContentLoaded', function () {
    const taskForm = document.getElementById('task-form');
    const accessToken = localStorage.getItem('accessToken');

    const apiUrl = 'http://127.0.0.1:8000/api/tasks';

    taskForm.addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(taskForm);
        fetch(apiUrl, {
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
                    position: "right",
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
