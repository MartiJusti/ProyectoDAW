document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebarCloseToggle = document.getElementById('sidebarCloseToggle');
    const overlay = document.getElementById('overlay');

    const toggleSidebar = () => {
        const isHidden = sidebar.classList.contains('hidden');
        if (isHidden) {
            sidebar.classList.remove('hidden');
            sidebar.classList.remove('-translate-x-full');
            sidebar.classList.add('translate-x-0');
            overlay.classList.remove('hidden');
        } else {
            sidebar.classList.add('-translate-x-full');
            sidebar.classList.remove('translate-x-0');
            overlay.classList.add('hidden');

            sidebar.addEventListener('transitionend', function handleTransitionEnd() {
                sidebar.classList.add('hidden');
                sidebar.removeEventListener('transitionend', handleTransitionEnd);
            });
        }
    };

    //Muestra u oculta el sidebar y el overlay
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', toggleSidebar);
    }

    if (sidebarCloseToggle) {
        sidebarCloseToggle.addEventListener('click', toggleSidebar);
    }

    if (overlay) {
        overlay.addEventListener('click', toggleSidebar);
    }

});
