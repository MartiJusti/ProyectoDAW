@extends('layout')

@section('title', 'Chat')

@section('content')
    <div id="chat-container" class="max-w-2xl mx-auto p-4 bg-white rounded-lg shadow-md h-96 overflow-y-scroll flex flex-col-reverse">
    </div>
    <div class="max-w-2xl mx-auto p-4 bg-white rounded-lg shadow-md mt-4">
        <form id="message-form" class="flex">
            <input type="text" id="message-input" class="flex-grow border rounded-l-lg p-2 focus:outline-none"
                placeholder="Escribe un mensaje...">
            <button type="submit"
                class="bg-indigo-500 text-white px-4 py-2 rounded-r-lg hover:bg-indigo-600">Enviar</button>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const authUser = JSON.parse(localStorage.getItem('userInfo'));
            const otherUser = @json($otherUser);
            const accessToken = localStorage.getItem('accessToken');
            const chatContainer = document.getElementById('chat-container');
            const messageForm = document.getElementById('message-form');
            const messageInput = document.getElementById('message-input');
            const apiUrl = 'http://127.0.0.1:8000/api';

            function fetchMessages(otherUserId, accessToken) {
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
                        displayMessages(messages);
                    })
                    .catch(error => {
                        console.error('There was a problem with the fetch operation:', error);
                    });
            }

            function displayMessages(messages) {
                chatContainer.innerHTML = '';
                messages.reverse().forEach(message => {
                    const messageElement = document.createElement('div');
                    messageElement.classList.add('mb-4', 'p-3', 'rounded', 'max-w-sm');
                    if (message.sender_id === authUser.id) {
                        messageElement.classList.add('bg-green-100', 'self-end', 'text-right');
                        messageElement.innerText = `${authUser.username}: ${message.content}`;
                    } else {
                        messageElement.classList.add('bg-red-100', 'self-start', 'text-left');
                        messageElement.innerText = `${otherUser.name}: ${message.content}`;
                    }
                    chatContainer.appendChild(messageElement);
                });

                chatContainer.scrollTop = chatContainer.scrollHeight;
            }

            function sendMessage(content) {
                fetch(`${apiUrl}/messagesAPI`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization': `Bearer ${accessToken}`
                        },
                        body: JSON.stringify({
                            content: content,
                            sender_id: authUser.id,
                            receiver_id: otherUser.id
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Error sending message');
                        }
                        return response.json();
                    })
                    .then(message => {
                        fetchMessages(otherUser.id, accessToken);
                    })
                    .catch(error => {
                        console.error('There was a problem with the send operation:', error);
                    });
            }

            messageForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const content = messageInput.value;
                if (content.trim() !== '') {
                    sendMessage(content);
                    messageInput.value = '';
                }
            });

            fetchMessages(otherUser.id, accessToken);
        });
    </script>
@endsection
