export function showToast(message, background) {
    Toastify({
        text: message,
        duration: 1250,
        gravity: "top",
        position: "center",
        style: {
            background: background,
        }
    }).showToast();
}
