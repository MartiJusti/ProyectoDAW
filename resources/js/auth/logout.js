document.addEventListener('DOMContentLoaded', function () {

    const loginLink = document.getElementById('login-link');
    const logoutLink = document.getElementById('logout-link');
    const tasksLink = document.getElementById('tasks-link');
    const taskCreateLink = document.getElementById('task-create-link');
    const messagesLink = document.getElementById('messages-link');
    const profileLink = document.getElementById('profile-link');
    const calendarLink = document.getElementById('calendar-link');
    const usersLink = document.getElementById('users-link');

    const userInfo = JSON.parse(localStorage.getItem('userInfo'));
    const accessToken = localStorage.getItem('accessToken');
    const apiUrl = 'http://127.0.0.1:8000/api/logout';

    if (userInfo && userInfo.rol.toLocaleLowerCase() == 'admin') {
        usersLink.classList.remove('hidden');
    } else {
        usersLink.classList.add('hidden');
    }

    if (accessToken) {
        if (loginLink) loginLink.classList.add('hidden');
        if (logoutLink) logoutLink.classList.remove('hidden');
    } else {
        if (loginLink) loginLink.classList.remove('hidden');
        if (logoutLink) logoutLink.classList.add('hidden');
        if (tasksLink) tasksLink.classList.add('hidden');
        if (taskCreateLink) taskCreateLink.classList.add('hidden');
        if (messagesLink) messagesLink.classList.add('hidden');
        if (profileLink) profileLink.classList.add('hidden');
        if (calendarLink) calendarLink.classList.add('hidden');
    }

    if (logoutLink) {
        logoutLink.addEventListener('click', function () {
            fetch(apiUrl, {
                    method: 'POST',
                    headers: {
                        'Authorization': `Bearer ${accessToken}`
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error al cerrar sesión');
                    }
                    return response.json();
                })
                .then(data => {
                    localStorage.removeItem('accessToken');
                    localStorage.removeItem('userInfo');
                    window.location.href = "/login";
                })
                .catch(error => {
                    console.error('Error al cerrar sesión:', error);
                });
        });
    }
});
