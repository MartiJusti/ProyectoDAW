const accessToken = localStorage.getItem('accessToken');
const userInfo = JSON.parse(localStorage.getItem('userInfo'));

console.log(userInfo.id);

document.addEventListener('DOMContentLoaded', function () {

    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'es',
        events: `http://127.0.0.1:8000/api/calendar/${userInfo.id}/tasks`,
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
        eventClick: function (info) {
            window.location.href = `/tasks/${info.event.id}`;
        }
    });

    calendar.render();
});
