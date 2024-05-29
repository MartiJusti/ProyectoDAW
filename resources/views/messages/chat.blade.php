@extends('layout')

@section('title', 'Chat')

@section('content')
    <div id="chat-container"
        class="max-w-2xl mx-auto p-4 bg-white rounded-lg shadow-md h-96 overflow-y-scroll flex flex-col-reverse mt-10">
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
    @vite('resources/js/messages/chat.js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const authUser = JSON.parse(localStorage.getItem('userInfo'));
            const otherUser = @json($otherUser);
            const accessToken = localStorage.getItem('accessToken');

            initializeChat(authUser, otherUser, accessToken);
        });
    </script>
@endsection
