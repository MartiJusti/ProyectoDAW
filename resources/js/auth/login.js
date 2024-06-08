document.addEventListener('DOMContentLoaded', function () {
    const loginForm = document.getElementById('login-form');
    const accessToken = localStorage.getItem('accessToken');
    const apiUrl = 'http://127.0.0.1:8000/api/login';

    if (accessToken) {
        window.location.href = '/tasks';
    }

    loginForm.addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(loginForm);
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
                const accessToken = data['access-token'];
                localStorage.setItem('accessToken', accessToken);
                showToast("Sesión iniciada con éxito", "linear-gradient(to right, #00b09b, #96c93d)", true);
            })
            .catch(error => {
                console.error(error.message);
                showToast(error.message, "linear-gradient(to right, #DB0202, #750000)", false);
            });
    });

    function showToast(message, background, executeCallback) {
        Toastify({
            text: message,
            duration: 1250,
            gravity: "top",
            position: "center",
            style: {
                background: background,
            },
            callback: function () {
                if (executeCallback) {
                    window.location.href = '/';
                }
            }
        }).showToast();
    }
});
