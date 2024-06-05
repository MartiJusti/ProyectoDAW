document.addEventListener('DOMContentLoaded', function () {
    const accessToken = localStorage.getItem('accessToken');
    const userInfo = JSON.parse(localStorage.getItem('userInfo'));
    const apiUrl = 'http://127.0.0.1:8000/api';
    const searchInput = document.getElementById('search');
    let users = [];

    async function fetchUsers() {
        try {
            const response = await fetch(`${apiUrl}/users`, {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${accessToken}`
                }
            });

            if (!response.ok) {
                throw new Error('Error al obtener los usuarios.');
            }

            users = await response.json();
            renderUsers(users);
        } catch (error) {
            /* console.error(error.message); */
        }
    }

    function renderUsers(users) {
        const usersContainer = document.getElementById('users-container');
        usersContainer.innerHTML = '';

        if (users.length === 0) {
            usersContainer.innerHTML = '<p>No hay usuarios registrados.</p>';
        } else {
            const table = document.createElement('table');
            table.className = 'w-full text-left table-compact';

            const tbody = document.createElement('tbody');
            users.forEach(user => {
                const row = document.createElement('tr');
                row.className = 'border-b border-gray-200 cursor-pointer hover:bg-blue-100';

                const avatarCell = document.createElement('td');
                avatarCell.className = 'p-2';
                avatarCell.innerHTML = `<img src="storage/img/avatar.png" alt="Avatar Image" class="h-6 w-6 md:h-8 md:w-8 rounded-full">`;

                const usernameCell = document.createElement('td');
                usernameCell.className = 'p-2 font-medium text-sm md:text-base';
                usernameCell.innerText = user.username;

                const nameCell = document.createElement('td');
                nameCell.className = 'p-2 text-sm md:text-base';
                nameCell.innerText = user.name;

                const emailCell = document.createElement('td');
                emailCell.className = 'p-2 text-sm md:text-base';
                emailCell.innerText = user.email;

                const birthdayCell = document.createElement('td');
                birthdayCell.className = 'p-2 text-sm md:text-base';
                birthdayCell.innerText = formatDate(user.birthday);

                const roleCell = document.createElement('td');
                roleCell.className = 'p-2 text-sm md:text-base';
                roleCell.innerText = user.rol;

                row.appendChild(avatarCell);
                row.appendChild(usernameCell);
                row.appendChild(nameCell);
                row.appendChild(emailCell);
                row.appendChild(birthdayCell);
                row.appendChild(roleCell);

                row.addEventListener('click', function () {
                    window.location.href = `/users/${user.id}`;
                });

                tbody.appendChild(row);
            });

            table.appendChild(tbody);
            usersContainer.appendChild(table);
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

    const normalizeString = (str) => {
        return str
            .normalize("NFD")
            .replace(/[\u0300-\u036f]/g, "")
            .toLowerCase();
    };

    searchInput.addEventListener('input', function (e) {
        const searchTerm = e.target.value.toLowerCase();
        const filteredUsers = users.filter(user => normalizeString(user.name).includes(normalizeString(searchTerm)) ||
            normalizeString(user.username).includes(normalizeString(searchTerm)));
        renderUsers(filteredUsers);
    });

    fetchUsers();
});
