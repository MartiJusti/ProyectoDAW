document.addEventListener('DOMContentLoaded', function () {
    const userName = document.getElementById("name");
    const userUsername = document.getElementById("username");
    const userEmail = document.getElementById("email");
    const userBirthday = document.getElementById("birthday");

    const userInfo = JSON.parse(localStorage.getItem('userInfo'));

    if (userInfo) {
        userName.textContent = userInfo.name;
        userUsername.textContent = userInfo.username;
        userEmail.textContent = userInfo.email;
        userBirthday.textContent = formatDate(userInfo.birthday);
    }

    userName.addEventListener('click', function () {

    });


    function formatDate(dateString) {
        const localeDate = {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric'
        };
        return new Date(dateString).toLocaleDateString('es-ES', localeDate);
    }
});
