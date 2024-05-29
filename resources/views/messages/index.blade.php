@extends('layout')

@section('title', 'Mensajes')

@section('content')
    <div class="max-w-md mx-auto p-4 bg-white rounded-lg shadow-lg mt-10">
        <div id="users-list"></div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const usersList = document.getElementById('users-list');
            const accessToken = localStorage.getItem('accessToken');
            const authUser = JSON.parse(localStorage.getItem('userInfo'));
            const apiUrl = 'http://127.0.0.1:8000/api';

            fetch(`${apiUrl}/usersAPI`, {
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
                        .filter(user => user.id !== authUser.id)
                        .forEach(user => {
                            const userLink = document.createElement('a');
                            userLink.classList.add('block', 'p-4', 'border-b', 'border-gray-200',
                                'cursor-pointer', 'hover:bg-gray-100');
                            userLink.textContent = user.name;
                            userLink.href = `/chat/${user.id}`;
                            usersList.appendChild(userLink);
                        });
                })
                .catch(error => {
                    console.error('Error al obtener la lista de usuarios:', error);
                });
        });
    </script>
@endsection
