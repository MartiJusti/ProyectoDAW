@extends('layout')

@section('title', 'Borrar tarea')

@section('content')

@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const accessToken = localStorage.getItem('accessToken');
            const taskId = @json($task->id);

            const apiUrl = 'http://127.0.0.1:8000/api/tasksAPI/';

            console.log(accessToken);
            console.log(taskId);

            fetch(`${apiUrl}${taskId}`, {
                    method: 'DELETE',
                    headers: {
                        'Authorization': `Bearer ${accessToken}`,
                    },
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error al borrar.');
                    }
                    return response.json();
                })
                .then(data => {
                    window.location.href = '/tasks';

                })
                .catch(error => {
                    console.error(error.message);
                });
        });
    </script>
@endsection
