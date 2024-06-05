document.addEventListener('DOMContentLoaded', function () {
    const taskList = document.getElementById('task-list');
    const searchInput = document.getElementById('search');
    const accessToken = localStorage.getItem('accessToken');
    const userInfo = JSON.parse(localStorage.getItem('userInfo'));

    const apiUrl = 'http://127.0.0.1:8000/api';

    let tasks = [];

    fetch(`${apiUrl}/users/${userInfo.id}/tasks`, {
            headers: {
                'Authorization': `Bearer ${accessToken}`
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al obtener las tareas');
            }
            return response.json();
        })
        .then(data => {
            tasks = data;
            displayTasks(tasks);
        })
        .catch(error => {
            /* console.error(error); */
        });

    searchInput.addEventListener('input', function (e) {
        const searchTerm = e.target.value.toLowerCase();
        const filteredTasks = tasks.filter(task => task.name.toLowerCase().includes(searchTerm));
        displayTasks(filteredTasks);
    });

    function displayTasks(tasks) {
        taskList.innerHTML = '';

        if (tasks.length === 0) {
            const noTasksMessage = document.createElement('p');
            noTasksMessage.textContent = 'No hay ninguna tarea.';
            noTasksMessage.classList.add('text-gray-500', 'text-center', 'mt-4');
            taskList.appendChild(noTasksMessage);
            return;
        }

        tasks.forEach(task => {
            const card = document.createElement('div');
            card.classList.add('bg-gray-200', 'p-4', 'rounded-md', 'shadow-md',
                'hover:shadow-lg', 'transition', 'duration-300',
                'ease-in-out',
                'transform', 'hover:scale-105', 'cursor-pointer');

            const taskLink = document.createElement('a');
            taskLink.href = `/tasks/${task.id}`;
            taskLink.classList.add('w-full', 'h-full', 'block');
            taskLink.addEventListener('click', (e) => {
                e.stopPropagation();
            });

            const title = document.createElement('h2');
            title.classList.add('text-lg', 'font-semibold', 'mb-2');
            title.textContent = task.name;

            const dateSection = document.createElement('div');
            dateSection.classList.add('flex', 'items-center', 'justify-between',
                'mt-4');

            const startDate = document.createElement('span');
            startDate.classList.add('text-sm', 'text-gray-500');
            startDate.textContent = `Inicio: ${formatDate(task.date_start)}`;
            dateSection.appendChild(startDate);

            const endDate = document.createElement('span');
            endDate.classList.add('text-sm', 'text-gray-500');
            endDate.textContent = `Fin: ${formatDate(task.date_end)}`;
            dateSection.appendChild(endDate);

            taskLink.appendChild(title);
            taskLink.appendChild(dateSection);

            card.appendChild(taskLink);
            taskList.appendChild(card);
        });
    }

    function formatDate(dateString) {
        const localteDate = {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric'
        };
        return new Date(dateString).toLocaleDateString('es-ES', localteDate);
    }
});
