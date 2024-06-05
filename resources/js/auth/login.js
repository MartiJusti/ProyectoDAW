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
                localStorage.setItem('userInfo', JSON.stringify(data['user']));
                showToast("Sesión iniciada con éxito", "linear-gradient(to right, #00b09b, #96c93d)");
            })
            .catch(error => {
                /* console.error(error.message); */
                alert(error.message);
            });
    });

    function showToast(message, background) {
        Toastify({
            text: message,
            duration: 1250,
            gravity: "top",
            position: "right",
            style: {
                background: background,
            },
            callback: function () {

                    window.location.href = '/';

            }
        }).showToast();
    }
});
