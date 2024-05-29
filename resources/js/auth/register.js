document.addEventListener('DOMContentLoaded', function () {
    const registerForm = document.getElementById('register-form');

    registerForm.addEventListener('submit', function (e) {
        e.preventDefault();
        const apiUrl = 'http://127.0.0.1:8000/api/register';
        const formData = new FormData(registerForm);

        formData.forEach((value, key) => {
            console.log(`${key}: ${value}`);
        });
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
                window.location.href = '/login';
            })
            .catch(error => {
                console.error('Error al crear cuenta:', error.message);

            });
    });
});
