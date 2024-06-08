/* Función que recorre el objeto de los errores recibidos y
los muestra debajo de cada campo */
export function displayErrors(errors) {
    for (const [field, messages] of Object.entries(errors)) {
        const input = document.querySelector(`[name="${field}"]`);
        if (input) {
            messages.forEach(message => {
                const errorElement = document.createElement('p');
                errorElement.classList.add('text-red-500', 'text-xs', 'italic', 'error-form');
                errorElement.textContent = message;
                input.parentNode.appendChild(errorElement);
            });
        }
    }
}

export function clearErrors() {
    const errorElements = document.querySelectorAll('.error-form');
    errorElements.forEach(element => element.remove());
}
