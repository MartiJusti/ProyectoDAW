<div id="sidebar" class="bg-white text-black w-64 space-y-6 py-7 px-2 fixed right-0 h-full hidden lg:block shadow-lg">
    <nav class="space-y-4">
        <a href="{{ route('auth.login') }}" id="login-link"
            class="block py-2 px-4 border-b border-gray-300 hover:bg-gray-200">
            Iniciar sesión
        </a>
        <a href="{{ route('auth.register') }}" class="block py-2 px-4 border-b border-gray-300 hover:bg-gray-200">
            Crear cuenta
        </a>
        <a href="{{ route('tasks.index') }}" id="tasks-link"
            class="block py-2 px-4 border-b border-gray-300 hover:bg-gray-200">
            Tareas
        </a>
        <a href="{{ route('tasks.create') }}" id="task-create-link"
            class="block py-2 px-4 border-b border-gray-300 hover:bg-gray-200">
            Crear Tarea
        </a>
        <a href="{{ route('messages.index') }}" id="messages-link"
            class="block py-2 px-4 border-b border-gray-300 hover:bg-gray-200">
            Mensajes
        </a>
        <a href="{{ route('calendar') }}" id="calendar-link"
            class="block py-2 px-4 border-b border-gray-300 hover:bg-gray-200">
            Calendario
        </a>
        <a href="{{ route('users.account') }}" id="profile-link"
            class="block py-2 px-4 border-b border-gray-300 hover:bg-gray-200">
            Perfil
        </a>
        <a id="logout-link" class="block py-2 px-4 border-b border-gray-300 cursor-pointer hover:bg-gray-200">
            Cerrar sesión
        </a>
    </nav>
</div>

<!-- Botón hamburguesa -->
<button id="sidebarToggle" class="lg:hidden fixed right-0 mr-4 mt-4 z-50">
    <svg class="w-8 h-8 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"
        xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
    </svg>
</button>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const loginLink = document.getElementById('login-link');
        const logoutLink = document.getElementById('logout-link');
        const tasksLink = document.getElementById('tasks-link');
        const taskCreateLink = document.getElementById('task-create-link');
        const messagesLink = document.getElementById('messages-link');
        const profileLink = document.getElementById('profile-link');
        const calendarLink = document.getElementById('calendar-link');

        const accessToken = localStorage.getItem('accessToken');
        const apiUrl = 'http://127.0.0.1:8000/api/logout';

        //PREGUNTAR SI CAMBIAR ACCESS TOKEN POR USER INFO EN LA COMPROBACIÓN
        if (accessToken) {
            if (loginLink) loginLink.classList.add('hidden');
            if (logoutLink) logoutLink.classList.remove('hidden');
        } else {
            if (loginLink) loginLink.classList.remove('hidden');
            if (logoutLink) logoutLink.classList.add('hidden');
            if (tasksLink) tasksLink.classList.add('hidden');
            if (taskCreateLink) taskCreateLink.classList.add('hidden');
            if (messagesLink) messagesLink.classList.add('hidden');
            if (profileLink) profileLink.classList.add('hidden');
            if (calendarLink) calendarLink.classList.add('hidden');
        }

        if (logoutLink) {
            logoutLink.addEventListener('click', function() {
                fetch(apiUrl, {
                        method: 'POST',
                        headers: {
                            'Authorization': `Bearer ${accessToken}`
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Error al cerrar sesión');
                        }
                        return response.json();
                    })
                    .then(data => {
                        localStorage.removeItem('accessToken');
                        localStorage.removeItem('userInfo');
                        window.location.href = "{{ route('auth.login') }}";
                    })
                    .catch(error => {
                        console.error('Error al cerrar sesión:', error);
                    });
            });
        }

        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');

        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', function() {
                if (sidebar) {
                    sidebar.classList.toggle('hidden');
                }
            });
        }
    });
</script>
