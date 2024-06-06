async function deleteTask(apiUrl, taskId, accessToken) {
    try {
        const response = await fetch(`${apiUrl}/tasks/${taskId}`, {
            method: 'DELETE',
            headers: {
                'Authorization': `Bearer ${accessToken}`,
            },
        });

        if (response.status === 204) {
            showToast("Tarea eliminada con éxito", "linear-gradient(to right, #00b09b, #96c93d)");
        } else {
            const data = await response.json();
            throw new Error(data.error || 'Error al borrar.');
        }
    } catch (error) {
        console.error(error.message);
    }
}


function showConfirm(apiUrl, userId, taskId, users, accessToken) {
    $.confirm({
        title: '¿Seguro que quieres borrar esta tarea?',
        content: 'La acción es irreversible.',
        type: 'red',
        boxWidth: '60%',
        useBootstrap: false,
        icon: 'fa fa-warning',
        closeIcon: true,
        closeIconClass: 'fa fa-close',
        animateFromElement: false,
        animation: 'scale',
        backgroundDismiss: false,
        backgroundDismissAnimation: 'shake',
        buttons: {
            confirm: {
                text: 'Confirmar',
                btnClass: 'btn-green',
                action: async function () {
                    await deleteTask(apiUrl, taskId, accessToken);
                }
            },
            cancel: {
                text: 'Cancelar',
                btnClass: 'btn-red',
                action: function () {

                }
            },
        }
    });
}

function showToast(message, background) {
    Toastify({
        text: message,
        duration: 1500,
        gravity: "top",
        position: "center",
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

        showConfirm(apiUrl, taskId, accessToken);

    });
};
