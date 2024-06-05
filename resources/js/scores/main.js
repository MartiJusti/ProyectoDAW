async function fetchUserScores(apiUrl, taskId, accessToken) {
    try {
        const response = await fetch(`${apiUrl}/scores/tasks/${taskId}`, {
            method: 'GET',
            headers: {
                'Authorization': `Bearer ${accessToken}`
            }
        });

        if (!response.ok) {
            throw new Error('Error al obtener las puntuaciones de los usuarios.');
        }

        const scores = await response.json();
        const scoresContainer = document.getElementById("user-scores");
        scoresContainer.innerHTML = '';

        if (scores.length === 0) {
            scoresContainer.innerHTML = '<p>No hay puntuaciones registradas para esta tarea.</p>';
        } else {
            const table = document.createElement('table');
            table.className = 'min-w-full bg-white';

            const thead = document.createElement('thead');
            thead.innerHTML = `
                <tr>
                    <th class="py-2">Nombre</th>
                    <th class="py-2">Puntuación</th>
                </tr>
            `;
            table.appendChild(thead);

            const tbody = document.createElement('tbody');

            for (const score of scores) {
                const userResponse = await fetch(`${apiUrl}/users/${score.user_id}`, {
                    method: 'GET',
                    headers: {
                        'Authorization': `Bearer ${accessToken}`
                    }
                });

                if (!userResponse.ok) {
                    throw new Error('Error al obtener la información del usuario.');
                }

                const user = await userResponse.json();
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td class="py-2">${user.name}</td>
                    <td class="py-2">${score.points ?? 0}</td>
                `;
                tbody.appendChild(row);
            }

            table.appendChild(tbody);
            scoresContainer.appendChild(table);
        }
    } catch (error) {
        /* console.error(error.message); */
    }
}

window.initializeScoreFunctions = function (apiUrl, taskId, accessToken) {
    fetchUserScores(apiUrl, taskId, accessToken);
};
