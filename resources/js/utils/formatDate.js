export function formatDate(dateString) {
    const localeDate = {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric'
    };
    return new Date(dateString).toLocaleDateString('es-ES', localeDate);
}
