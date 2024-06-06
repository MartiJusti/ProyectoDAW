document.addEventListener('DOMContentLoaded', function () {
    const accessToken = localStorage.getItem('accessToken');
    const isPublicView = document.body.classList.contains('public-view');
    const currentPath = window.location.pathname;
    const loginPath = '/login';

    if (!accessToken && !isPublicView && currentPath !== loginPath) {
        document.title = 'Redirigiendo a Login...';
        window.location.href = loginPath;
    } else {
        document.title = document.querySelector('title').textContent;
        document.body.classList.remove('loading');
    }
});
