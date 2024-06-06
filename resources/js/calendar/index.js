const accessToken = localStorage.getItem('accessToken');
const userInfo = JSON.parse(localStorage.getItem('userInfo'));

document.addEventListener('DOMContentLoaded', async function () {
    const apiUrl = 'http://127.0.0.1:8000/api';

    var calendarEl = document.getElementById('calendar');

    async function fetchEvents() {
        try {
            const response = await fetch(`${apiUrl}/calendar/${userInfo.id}/tasks`, {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${accessToken}`
                }
            });
            if (!response.ok) {
                /* console.error(response.statusText); */
                return [];
            }
            const data = await response.json();

            if (Array.isArray(data)) {
                return data;
            } else {
                /* console.error(data); */
                return [];
            }
        } catch (error) {
            /* console.error(error); */
            return [];
        }
    }

    async function fetchAdminEvents() {
        try {
            const response = await fetch(`${apiUrl}/calendar/tasks`, {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${accessToken}`
                }
            });
            if (!response.ok) {
                /* console.error(response.statusText); */
                return [];
            }
            const data = await response.json();

            if (Array.isArray(data)) {
                return data;
            } else {
                /* console.error(data); */
                return [];
            }
        } catch (error) {
            /* console.error(error); */
            return [];
        }
    }

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'es',
        editable: false,
        eventStartEditable: false,
        events: async function (fetchInfo, successCallback, failureCallback) {
            if (userInfo.rol === 'admin') {
                const adminTasks = await fetchAdminEvents();
                successCallback(adminTasks);
            } else {
                const events = await fetchEvents();
                successCallback(events);
            }
        },
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: ''
        },
        buttonText: {
            today: 'Hoy'
        },
        eventClick: function (info) {
            window.location.href = `/tasks/${info.event.id}`;
        }
    });

    calendar.render();
});
