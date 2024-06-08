export async function getUserInfo(apiUrl, accessToken) {
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
        return data;
    } catch (error) {
        console.error(error.message);
        return null;
    }
}
