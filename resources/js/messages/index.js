import {
    getUserInfo
} from "../utils/getUserInfo";

document.addEventListener('DOMContentLoaded', async function () {
    const usersList = document.getElementById('users-list');
    const accessToken = localStorage.getItem('accessToken');
    const apiUrl = 'http://127.0.0.1:8000/api';


    const userInfo = await getUserInfo(apiUrl, accessToken);
    console.log(userInfo.rol);

    fetch(`${apiUrl}/users`, {
            headers: {
                'Authorization': `Bearer ${accessToken}`
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al obtener la lista de usuarios');
            }
            return response.json();
        })
        .then(users => {
            usersList.innerHTML = '';

            users
                .filter(user => user.id !== userInfo.id)
                .forEach(user => {
                    const userLink = document.createElement('a');
                    userLink.classList.add('flex', 'items-center', 'p-4', 'border-b', 'border-gray-200', 'cursor-pointer', 'hover:bg-gray-100', 'gap-2');
                    userLink.innerHTML = `<span class="font-bold">${user.username}</span> (${user.name})`;

                    const userAvatar = document.createElement('img');
                    userAvatar.src = 'storage/img/avatar.png';
                    userAvatar.alt = 'Avatar Image';
                    userAvatar.classList.add('h-6', 'w-6', 'md:h-8', 'md:w-8', 'rounded-full'); // Add Tailwind CSS classes for styling

                    userLink.href = `/chat/${user.id}`;
                    userLink.prepend(userAvatar);
                    usersList.appendChild(userLink);
                });

        })
        .catch(error => {
            console.error(error);
        });
});
