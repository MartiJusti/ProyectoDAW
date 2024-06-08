import { showToastWithCallback } from "../utils/showToastWithCallback";

document.addEventListener('DOMContentLoaded', async function () {
    const userName = document.getElementById("name");
    const userUsername = document.getElementById("username");
    const userEmail = document.getElementById("email");
    const userBirthday = document.getElementById("birthday");
    const editLink = document.getElementById("edit-link");
    const deleteButton = document.getElementById("delete-btn");

    const apiUrl = 'http://127.0.0.1:8000/api';
    const accessToken = localStorage.getItem('accessToken');

    try {
        const user = await getCurrentUser();
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

    async function getCurrentUser() {
        try {
            const response = await fetch(`${apiUrl}/currentUser`, {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${accessToken}`,
                    'Content-Type': 'application/json'
                },
            });

            if (!response.ok) {
                throw new Error('No autorizado');
            }

            const user = await response.json();
            return user;
        } catch (error) {
            console.error('Error:', error);
        }
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

    function formatDate(dateString) {
        const localeDate = {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric'
        };
        return new Date(dateString).toLocaleDateString('es-ES', localeDate);
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
                    action: function () {
                    }
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
