@extends('layout')

@section('title', 'Calendario')

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css" rel="stylesheet">
    <style>
        .fc-toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .fc-toolbar h2 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #4A5568;
        }

        .fc-button {
            background-color: #4299E1;
            border-color: #4299E1;
            color: #fff;
            padding: 0.5rem 1rem;
            border-radius: 0.25rem;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .fc-button:hover {
            background-color: #3182CE;
            border-color: #3182CE;
        }

        .fc-daygrid-day-number {
            font-size: 0.875rem;
            font-weight: 700;
            color: #2D3748;
        }

        .fc-event {
            background-color: #48BB78;
            border: none;
            padding: 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: #fff;
        }

        .fc-event:hover {
            background-color: #38A169;
        }
    </style>
@endsection

@section('content')
    <div class="max-w-4xl mx-auto mt-8">
        <div id="calendar" class="p-4 bg-white rounded-lg shadow-lg"></div>
    </div>
@endsection

@section('scripts')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/locales-all.min.js'></script>

    <script>
        const accessToken = localStorage.getItem('accessToken');

        document.addEventListener('DOMContentLoaded', function() {

            fetch('http://127.0.0.1:8000/api/currentUser', {
                    headers: {
                        'Authorization': `Bearer ${accessToken}`
                    }
                })
                .then(response => response.json())
                .then(data => {
                    const userId = data.id;

                    var calendarEl = document.getElementById('calendar');

                    var calendar = new FullCalendar.Calendar(calendarEl, {
                        initialView: 'dayGridMonth',
                        locale: 'es',
                        events: `http://127.0.0.1:8000/api/calendar/${userId}/tasks`,
                        headerToolbar: {
                            left: 'prev,next today',
                            center: 'title',
                            right: ''
                        },
                        buttonText: {
                            today: 'Hoy'
                        },
                        editable: true,
                        droppable: true,
                        eventClick: function(info) {
                            window.location.href = `/tasks/${info.event.id}`;
                        }
                    });

                    calendar.render();
                })
                .catch(error => {
                    console.error('Error al obtener el ID del usuario actual:', error);
                });
        });
    </script>
@endsection
