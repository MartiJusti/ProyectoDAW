@extends('layout')

@section('title', 'Borrar tarea')

@section('content')

@endsection

@section('scripts')
    @vite('resources/js/destroy.js')

    <script type="module">
        import {
            deleteTask
        } from '/resources/js/destroy.js';
        document.addEventListener('DOMContentLoaded', function() {
            const accessToken = localStorage.getItem('accessToken');
            const taskId = @json($task->id);
            deleteTask(accessToken, taskId);
        });
    </script>
@endsection
