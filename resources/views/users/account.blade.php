@extends('layout')

@section('title', 'Perfil de Usuario')

@section('content')
    <div class="container mx-auto py-8">
        <div class="max-w-md mx-auto bg-white shadow-md rounded-md overflow-hidden">
            <div class="p-6">
                <h2 class="text-2xl font-semibold mb-4">Datos del Usuario</h2>
                <div class="flex flex-col space-y-4">
                    <div class="flex items-center">
                        <span class="font-semibold w-1/3">Nombre:</span>
                        <span id="name" class="w-2/3"></span>
                    </div>
                    <div class="flex items-center">
                        <span class="font-semibold w-1/3">Nombre de Usuario:</span>
                        <span id="username" class="w-2/3"></span>
                    </div>
                    <div class="flex items-center">
                        <span class="font-semibold w-1/3">Correo Electrónico:</span>
                        <span id="email" class="w-2/3"></span>
                    </div>
                    <div class="flex items-center">
                        <span class="font-semibold w-1/3">Fecha de Nacimiento:</span>
                        <span id="birthday" class="w-2/3"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const userName = document.getElementById("name");
        const userUsername = document.getElementById("username");
        const userEmail = document.getElementById("email");
        const userBirthday = document.getElementById("birthday");

        const apiUrl = "http://127.0.0.1:8000/api/currentUser";
        const accessToken = localStorage.getItem('accessToken');

        fetch(apiUrl, {
            headers: {
                'Authorization': `Bearer ${accessToken}`
            }
        }).then((response) => {
            if (!response.ok) {
                throw new Error('Error al obtener información del usuario');
            }
            return response.json();

        })
        .then(data => {
            userName.textContent = data.name;
            userUsername.textContent = data.username;
            userEmail.textContent = data.email;
            userBirthday.textContent = data.birthday;
        })
        .catch((err) => {
            console.error(err);
        });
    </script>
@endsection
