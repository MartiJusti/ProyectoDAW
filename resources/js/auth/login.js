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
                window.location.href = '/tasks';
            })
            .catch(error => {
                console.error('Error al iniciar sesión:', error.message);
                alert(error.message);
            });
    });
});
