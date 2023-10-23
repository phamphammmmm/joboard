document.addEventListener('DOMContentLoaded', () => {
    const notificationIcon = document.getElementById('notificationIcon');
    const notificationPopup = document.getElementById('notificationPopup');

    notificationIcon.addEventListener('click', () => {
        notificationPopup.style.display = 'block';
    });

    notificationPopup.addEventListener('click', (event) => {
        if (event.target === notificationPopup) {
            notificationPopup.style.display = 'none';
        }
    });
});
