async function editUser(userId, accessToken) {
    const userForm = document.getElementById('edit-user-form');
    const apiUrl = 'http://127.0.0.1:8000/api';

    userForm.addEventListener('submit', async function (e) {
        e.preventDefault();

        const formData = new FormData(userForm);
        const jsonData = {};

        formData.forEach((value, key) => {
            jsonData[key] = value;
        });

        try {
            const response = await fetch(`${apiUrl}/users/${userId}`, {
                method: 'PATCH',
                headers: {
                    'Authorization': `Bearer ${accessToken}`,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(jsonData)
            });

            const data = await response.json();

            if (data) {
                showToast("Usuario editado con éxito", "linear-gradient(to right, #00b09b, #96c93d)", data.id);
            }

        } catch (error) {
            console.error(error.message);
        }
    });
}

function showToast(message, background, userId) {
    Toastify({
        text: message,
        duration: 1250,
        gravity: "top",
        position: "center",
        style: {
            background: background,
        },
        callback: function () {
            window.location.href = `/users/${userId}`;
        }
    }).showToast();

}

window.intializeEditUser = function(userId, accessToken) {
    editUser(userId, accessToken);
}
