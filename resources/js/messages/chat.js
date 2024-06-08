const apiUrl = 'http://127.0.0.1:8000/api';

async function getUserInfo(apiUrl, accessToken) {
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



function fetchMessages(otherUserId, accessToken, chatContainer, authUser, otherUser) {

    fetch(`${apiUrl}/messages/with/${otherUserId}`, {
            headers: {
                'Authorization': `Bearer ${accessToken}`
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(messages => {
            displayMessages(messages, chatContainer, authUser, otherUser);
        })
        .catch(error => {
            /* console.error(error); */
        });
}

function displayMessages(messages, chatContainer, authUser, otherUser) {
    chatContainer.innerHTML = '';
    if (messages.length === 0) {
        const noMessagesElement = document.createElement('div');
        noMessagesElement.classList.add('text-center', 'text-gray-500', 'mt-4');
        noMessagesElement.textContent = 'No tienes ningún mensaje con este usuario.';
        chatContainer.appendChild(noMessagesElement);
        return;
    }
    messages.reverse().forEach(message => {
        const messageElement = document.createElement('div');
        messageElement.classList.add('mb-4', 'p-3', 'rounded', 'max-w-sm');
        if (message.sender_id === authUser.id) {
            messageElement.classList.add('bg-green-100', 'self-end', 'text-right');
            messageElement.innerHTML =
                `<span class="font-bold">${authUser.username}</span>: ${message.content}`;
        } else {
            messageElement.classList.add('bg-red-100', 'self-start', 'text-left');
            messageElement.innerHTML =
                `<span class="font-bold">${otherUser.username}</span>: ${message.content}`;
        }
        chatContainer.appendChild(messageElement);
    });

    chatContainer.scrollTop = chatContainer.scrollHeight;
}

function sendMessage(content, accessToken, senderId, receiverId, callback) {

    fetch(`${apiUrl}/messages`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${accessToken}`
            },
            body: JSON.stringify({
                content: content,
                sender_id: senderId,
                receiver_id: receiverId
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error sending message');
            }
            return response.json();
        })
        .then(message => {
            callback();
        })
        .catch(error => {
            /* console.error(error); */
        });
}

/* function formatDate(dateString) {
    const localeDate = {
        hour: '2-digit',
        minute: '2-digit'
    };
    return new Date(dateString).toLocaleDateString('es-ES', localeDate);
} */

function formatDate(dateString) {
    const localeDate = {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric'
    };
    return new Date(dateString).toLocaleDateString('es-ES', localeDate);
}

window.initializeChat = async function (otherUser, accessToken) {
    const chatContainer = document.getElementById('chat-container');
    const messageForm = document.getElementById('message-form');
    const messageInput = document.getElementById('message-input');

    const userInfo = await getUserInfo(apiUrl, accessToken);
console.log(userInfo.rol);

    fetchMessages(otherUser.id, accessToken, chatContainer, userInfo, otherUser);

    messageForm.addEventListener('submit', function (e) {
        e.preventDefault();
        const content = messageInput.value;
        if (content.trim() !== '') {
            sendMessage(content, accessToken, userInfo.id, otherUser.id, () => {
                fetchMessages(otherUser.id, accessToken, chatContainer, userInfo, otherUser);
            });
            messageInput.value = '';
        }
    });
};
