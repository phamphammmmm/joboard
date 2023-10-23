document.addEventListener('DOMContentLoaded', () => {
    const addApplicationPopup = document.getElementById('addApplicationPopup');
    const addApplicationForm = document.getElementById('addApplicationForm');
    const jobIdInput = document.getElementById('job_id_input');

    addApplicationPopup.addEventListener('click', (event) => {
        if (event.target === addApplicationPopup) {
            addApplicationPopup.style.display = 'none';
        }
    });

    document.addEventListener('click', (event) => {
        if (event.target.classList.contains('add-application-btn')) {
            const jobId = event.target.getAttribute('data-id');
            jobIdInput.value = jobId;
            console.log(jobIdInput.value);
            addApplicationPopup.style.display = 'block';
        }
    });
});
