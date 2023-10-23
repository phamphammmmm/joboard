document.addEventListener('DOMContentLoaded', () => {
    const addApplicationBtns = document.querySelectorAll('.add-application-btn');
    const addApplicationPopup = document.getElementById('addApplicationPopup');
    const addApplicationForm = document.getElementById('addApplicationForm');
    const jobIdInput = document.getElementById('job_id_input');

    addApplicationPopup.addEventListener('click', (event) => {
        if (event.target === addApplicationPopup) {
            addApplicationPopup.style.display = 'none';
        }
    });

    addApplicationBtns.forEach((button) => {
        button.addEventListener('click', () => {
            const jobId = button.getAttribute('data-id');
            console.log(jobId)
            jobIdInput.value = jobId;

            addApplicationPopup.style.display = 'block';
        });
    });
});


