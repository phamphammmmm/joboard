document.addEventListener('DOMContentLoaded', () => {
    const editOrganizationButtons = document.querySelectorAll('.edit-Organization-btn');
    const popupOverlay = document.querySelector('.popup-overlay');
    const closeOverlayButton = document.querySelector('.close-overlay-button');
    const editOrganizationForm = document.getElementById('editOrganizationForm');
    const OrganizationIdInput = document.getElementById('Organization_id');
    const nameInput = document.getElementById('name');
    const sortInput = document.getElementById('sort');

    popupOverlay.addEventListener('click', (event) => {
        if (event.target === popupOverlay) {
            popupOverlay.style.display = 'none';
        }
    });

    editOrganizationButtons.forEach((button) => {
        button.addEventListener('click', () => {
            const row = button.parentNode.parentNode;
            const OrganizationId = button.getAttribute('data-id');
            const OrganizationName = row.querySelector('.name').textContent;
            const OrganizationSort = row.querySelector('.sort').textContent;

            OrganizationIdInput.value = OrganizationId;
            nameInput.value = OrganizationName;
            sortInput.value = OrganizationSort;

            popupOverlay.style.display = 'block';
        });
    });
});

//Add Organization popup
document.addEventListener('DOMContentLoaded', () => {
    // Lấy tham chiếu đến các phần tử
    const addOrganizationBtn = document.getElementById('addOrganizationBtn');
    const addOrganizationPopup = document.getElementById('addOrganizationPopup');
    const addOrganizationForm = document.getElementById('addOrganizationForm');

    // Xử lý sự kiện click để mở/đóng popup
    addOrganizationBtn.addEventListener('click', () => {
        addOrganizationPopup.style.display = 'block';
    });

    addOrganizationPopup.addEventListener('click', (event) => {
        if (event.target === addOrganizationPopup) {
            addOrganizationPopup.style.display = 'none';
        }
    });

});
