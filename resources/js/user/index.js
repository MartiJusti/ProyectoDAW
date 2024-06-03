document.addEventListener('DOMContentLoaded', function () {
    const accessToken = localStorage.getItem('accessToken');
    const userInfo = JSON.parse(localStorage.getItem('userInfo'));
    const apiUrl = 'http://127.0.0.1:8000/api';
    const searchInput = document.getElementById('search');
    let users = [];

    async function fetchUsers() {
        try {
            const response = await fetch(`${apiUrl}/usersAPI`, {
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
            console.error('Error al obtener los usuarios:', error.message);
        }
    }

    function renderUsers(users) {
        const usersContainer = document.getElementById('users-container');
        usersContainer.innerHTML = '';

        if (users.length === 0) {
            usersContainer.innerHTML = '<p>No hay usuarios registrados.</p>';
        } else {
            const table = document.createElement('table');
            table.className = 'min-w-full bg-white';

            const thead = document.createElement('thead');
            thead.innerHTML = `
                <tr>
                    <th class="py-2">ID</th>
                    <th class="py-2">Nombre</th>
                    <th class="py-2">Email</th>
                    <th class="py-2">Rol</th>
                </tr>
            `;
            table.appendChild(thead);

            const tbody = document.createElement('tbody');
            users.forEach(user => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td class="py-2">${user.id}</td>
                    <td class="py-2">${user.name}</td>
                    <td class="py-2">${user.email}</td>
                    <td class="py-2">${user.rol}</td>
                `;
                tbody.appendChild(row);
            });

            table.appendChild(tbody);
            usersContainer.appendChild(table);
        }
    }

    searchInput.addEventListener('input', function (e) {
        const searchTerm = e.target.value.toLowerCase();
        const filteredUsers = users.filter(user => user.name.toLowerCase().includes(searchTerm));
        renderUsers(filteredUsers);
    });

    fetchUsers();

});
