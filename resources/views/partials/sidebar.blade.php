<button id="sidebarToggle" class="fixed left-0 ml-4 mt-4 z-50 hover:bg-slate-200 hover:rounded-md">
    <svg id="hamburger-icon" class="w-8 h-8 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"
        xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
    </svg>
</button>

<div id="overlay" class="fixed inset-0 bg-black opacity-35 hidden z-40"></div>

<div id="sidebar"
    class="bg-slate-100 text-black w-64 space-y-6 py-7 px-2 fixed left-0 h-full hidden shadow-lg z-50 transform transition-transform -translate-x-full">
    <button id="sidebarCloseToggle" class="left-0 ml-2 mb-4 z-50 hover:bg-slate-200 hover:rounded-md">
        <svg id="close-sidebar-icon" class="w-8 h-8 text-gray-800" fill="none" stroke="currentColor"
            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </button>

    <nav class="space-y-4">
        <a href="{{ route('auth.login') }}" id="login-link"
            class="block py-2 px-4 border-b border-gray-300 hover:bg-gray-200">Iniciar sesión</a>
        <a href="{{ route('auth.register') }}" class="block py-2 px-4 border-b border-gray-300 hover:bg-gray-200">Crear
            cuenta</a>
        <a href="{{ route('tasks.index') }}" id="tasks-link"
            class="block py-2 px-4 border-b border-gray-300 hover:bg-gray-200">Tareas</a>
        <a href="{{ route('tasks.create') }}" id="task-create-link"
            class="block py-2 px-4 border-b border-gray-300 hover:bg-gray-200">Crear Tarea</a>
        <a href="{{ route('users.index') }}" id="users-link"
            class="block py-2 px-4 border-b border-gray-300 hover:bg-gray-200">Usuarios</a>
        <a href="{{ route('messages.index') }}" id="messages-link"
            class="block py-2 px-4 border-b border-gray-300 hover:bg-gray-200">Mensajes</a>
        <a href="{{ route('calendar') }}" id="calendar-link"
            class="block py-2 px-4 border-b border-gray-300 hover:bg-gray-200">Calendario</a>

        <div class="absolute bottom-0 pr-4 mb-3 space-y-4 w-full">
            <a href="{{ route('users.account') }}" id="profile-link"
                class="block py-2 px-4 border-b border-gray-300 hover:bg-gray-200">Perfil</a>
            <a id="logout-link" class="block py-2 px-4 cursor-pointer hover:bg-gray-200">Cerrar
                sesión</a>
        </div>
    </nav>
</div>

{{-- Estas directrices vite no está dentro de @section('scripts') porque no utilizan el layout --}}
@vite('resources/js/auth/logout.js')
@vite('resources/js/misc/sidebar.js')
