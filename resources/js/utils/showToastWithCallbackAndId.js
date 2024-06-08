export function showToastWithCallbackAndId(message, background, href, id) {
    Toastify({
        text: message,
        duration: 1250,
        gravity: "top",
        position: "center",
        style: {
            background: background,
        },
        callback: function () {
            window.location.href = `/${href}/${id}`;
        }
    }).showToast();

}
