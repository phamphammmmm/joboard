document.addEventListener('DOMContentLoaded', () => {
    const editcompanyButtons = document.querySelectorAll('.edit-company-btn');
    const popupOverlay = document.querySelector('.popup-overlay');
    const closeOverlayButton = document.querySelector('.close-overlay-button');
    const editCompanyForm = document.getElementById('editCompanyForm');
    const companyIdInput = document.getElementById('company_id');
    const nameInput = document.getElementById('name');
    const emailInput = document.getElementById('email');
    const descriptionInput = document.getElementById('description');

    popupOverlay.addEventListener('click', (event) => {
        if (event.target === popupOverlay) {
            popupOverlay.style.display = 'none';
        }
    });

    editcompanyButtons.forEach((button) => {
        button.addEventListener('click', () => {
            const row = button.parentNode.parentNode;
            const companyId = button.getAttribute('data-id');
            const companyName = row.querySelector('.name').textContent;
            const companyEmail = row.querySelector('.email').textContent;
            const companyDescription = row.querySelector('.description').textContent;

            companyIdInput.value = companyId;
            nameInput.value = companyName;
            emailInput.value = companyEmail;
            descriptionInput.value = companyDescription;

            popupOverlay.style.display = 'block';
        });
    });

    //Add company popup
    const addCompanyBtn = document.getElementById('addCompanyBtn');
    const addCompanyPopup = document.getElementById('addCompanyPopup');
    const addCompanyForm = document.getElementById('addCompanyForm');

    // Xử lý sự kiện click để mở popup
    addCompanyBtn.addEventListener('click', function () {
        addCompanyPopup.style.display = 'block';
    });

    // Xử lý sự kiện click để đóng popup
    addCompanyPopup.addEventListener('click', (event) => {
        if (event.target === addCompanyPopup) {
            addCompanyPopup.style.display = 'none';
        }
    });
});
