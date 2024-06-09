import {
    showToastWithCallback
} from "../utils/showToastWithCallback";

async function deleteUser(apiUrl, userId, accessToken) {
    try {
        const response = await fetch(`${apiUrl}/users/${userId}`, {
            method: 'DELETE',
            headers: {
                'Authorization': `Bearer ${accessToken}`,
            },
        });

        if (response.status === 204) {
            showToastWithCallback("Usuario eliminado con éxito", "linear-gradient(to right, #00b09b, #96c93d)", () => {
                window.location.href = '/users';
            });
        } else {
            const data = await response.json();
            throw new Error(data.error || 'Error al borrar.');
        }
    } catch (error) {
        /* console.error(error.message); */
    }
}


function showConfirm(apiUrl, userId, accessToken) {
    $.confirm({
        title: '¿Seguro que quieres eliminar a este usuario?',
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
            cancel: {
                text: 'Cancelar',
                btnClass: 'btn-red',
                action: function () {

                }
            },
            confirm: {
                text: 'Confirmar',
                btnClass: 'btn-green',
                action: async function () {
                    await deleteUser(apiUrl, userId, accessToken);
                }
            },
        }
    });
}

window.initializeDeleteUser = function (apiUrl, userId, accessToken) {
    const deleteButton = document.getElementById('delete-btn');
    deleteButton.addEventListener('click', function () {

        showConfirm(apiUrl, userId, accessToken);

    });
};
