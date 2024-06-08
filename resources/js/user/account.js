import {
    getUserInfo
} from "../utils/getUserInfo";
import {
    showToastWithCallback
} from "../utils/showToastWithCallback";
import {
    formatDate
} from "../utils/formatDate";

document.addEventListener('DOMContentLoaded', async function () {
    const userName = document.getElementById("name");
    const userUsername = document.getElementById("username");
    const userEmail = document.getElementById("email");
    const userBirthday = document.getElementById("birthday");
    const deleteButton = document.getElementById("delete-btn");

    const apiUrl = 'http://127.0.0.1:8000/api';
    const accessToken = localStorage.getItem('accessToken');

    try {
        const user = await getUserInfo(apiUrl, accessToken);
        userName.textContent = user.name;
        userUsername.textContent = user.username;
        userEmail.textContent = user.email;
        userBirthday.textContent = formatDate(user.birthday);

        deleteButton.addEventListener('click', function () {
            showConfirm(user.id);
        });
    } catch (error) {
        console.error('Error:', error);

    }


    async function deleteAccount(id) {
        try {
            const response = await fetch(`${apiUrl}/users/${id}`, {
                method: 'DELETE',
                headers: {
                    'Authorization': `Bearer ${accessToken}`,
                    'Content-Type': 'application/json'
                }
            });

            if (response.ok) {
                localStorage.removeItem('accessToken');
                showToastWithCallback("Cuenta eliminada con éxito", "linear-gradient(to right, #00b09b, #96c93d)", () => {
                    window.location.href = '/';
                });
            }
        } catch (error) {
            console.error(`Error inesperado al eliminar usuario: ${error}`);
        }
    }

    function showConfirm(userID) {
        $.confirm({
            title: '¿Seguro que quieres borrar tu cuenta?',
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
                    action: function () {}
                },
                confirm: {
                    text: 'Confirmar',
                    btnClass: 'btn-green',
                    action: async function () {
                        await deleteAccount(userID);
                    }
                },
            }
        });
    }
});
