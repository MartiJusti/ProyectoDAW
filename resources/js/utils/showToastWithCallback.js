/* Muestra el toast, y ejecuta una función al cerrarse */
export function showToastWithCallback(message, background, callback) {
    Toastify({
        text: message,
        duration: 1250,
        gravity: "top",
        position: "center",
        style: {
            background: background,
        },
        callback: function () {
            if (callback) {
                callback();
            }
        }
    }).showToast();
}
