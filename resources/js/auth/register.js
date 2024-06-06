document.addEventListener('DOMContentLoaded', function () {
    const registerForm = document.getElementById('register-form');
    const registerTitle = document.getElementById('register-title');
    const registerButton = document.getElementById('register-button');
    const rolSelect = document.getElementById('rol-select');
    const userInfo = JSON.parse(localStorage.getItem('userInfo'));

    if (userInfo && userInfo.rol.toLowerCase() !== 'admin') {
        window.location.href = "/";
    }

    if (userInfo && userInfo.rol.toLowerCase() === 'admin') {
        registerTitle.textContent = 'Crear cuenta';
        registerButton.textContent = 'Crear cuenta';
    }

    if (!userInfo || userInfo.rol.toLowerCase() !== 'admin') {
        rolSelect.classList.add('hidden');
    }

    registerForm.addEventListener('submit', function (e) {
        e.preventDefault();
        const apiUrl = 'http://127.0.0.1:8000/api/register';
        const formData = new FormData(registerForm);

        fetch(apiUrl, {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(
                        'Usuario no autorizado. Por favor, verifique sus credenciales.');
                }
                return response.json();
            })
            .then(data => {
                showToast("Cuenta creada con éxito", "linear-gradient(to right, #00b09b, #96c93d)");
                registerForm.reset();
            })
            .catch(error => {
                /* console.error(error.message); */

            });
    });

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
                if (!userInfo) {
                    window.location.href = '/login';
                }
            }
        }).showToast();
    }
});
