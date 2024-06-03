
function fetchMessages(otherUserId, accessToken, chatContainer, authUser, otherUser) {
    const apiUrl = 'http://127.0.0.1:8000/api';

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
            console.error('There was a problem with the fetch operation:', error);
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
                `<span class="font-bold">${authUser.username}</span>: ${message.content} ${formatDate(message.created_at)}`;
        } else {
            messageElement.classList.add('bg-red-100', 'self-start', 'text-left');
            messageElement.innerHTML =
                `<span class="font-bold">${otherUser.username}</span>: ${message.content} ${formatDate(message.created_at)}`;
        }
        chatContainer.appendChild(messageElement);
    });

    chatContainer.scrollTop = chatContainer.scrollHeight;
}

function sendMessage(content, accessToken, senderId, receiverId, callback) {
    const apiUrl = 'http://127.0.0.1:8000/api';

    fetch(`${apiUrl}/messagesAPI`, {
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
            console.error('There was a problem with the send operation:', error);
        });
}

function formatDate(dateString) {
    const localeDate = {
        hour: '2-digit',
        minute: '2-digit'
    };
    return new Date(dateString).toLocaleDateString('es-ES', localeDate);
}

window.initializeChat = function (authUser, otherUser, accessToken) {
    const chatContainer = document.getElementById('chat-container');
    const messageForm = document.getElementById('message-form');
    const messageInput = document.getElementById('message-input');

    fetchMessages(otherUser.id, accessToken, chatContainer, authUser, otherUser);

    messageForm.addEventListener('submit', function (e) {
        e.preventDefault();
        const content = messageInput.value;
        if (content.trim() !== '') {
            sendMessage(content, accessToken, authUser.id, otherUser.id, () => {
                fetchMessages(otherUser.id, accessToken, chatContainer, authUser, otherUser);
            });
            messageInput.value = '';
        }
    });
};
