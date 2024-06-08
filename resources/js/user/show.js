const apiUrl = 'http://127.0.0.1:8000/api';
const accessToken = localStorage.getItem('accessToken');

async function getUserRole(apiUrl, accessToken) {
    try {
        const response = await fetch(`${apiUrl}/currentUser`, {
            method: 'GET',
            headers: {
                'Authorization': `Bearer ${accessToken}`
            }
        });

        if (!response.ok) {
            throw new Error('Error al obtener la información del usuario.');
        }

        const data = await response.json();
        console.log(data.rol);
        return data.rol;
    } catch (error) {
        console.error(error.message);
        return null;
    }
}

const userRole = await getUserRole(apiUrl, accessToken);

if (userRole !== 'admin') {
    window.location.href = '/';
}
