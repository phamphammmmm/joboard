//Add category popup
document.addEventListener('DOMContentLoaded', () => {
    // Lấy tham chiếu đến các phần tử
    const addJobBtn = document.getElementById('addJobBtn');
    const addJobPopup = document.getElementById('addJobPopup');
    const addJobForm = document.getElementById('addJobForm');

    // Xử lý sự kiện click để mở/đóng popup
    addJobBtn.addEventListener('click', () => {
        addJobPopup.style.display = 'block';
    });

    addJobPopup.addEventListener('click', (event) => {
        if (event.target === addJobPopup) {
            addJobPopup.style.display = 'none';
        }
    });

    //form
    fetch('/api/companies')
        .then(response => response.json())
        .then(data => {
            const companySelect = document.getElementById('company_id');

            data.forEach(company => {
                const option = document.createElement('option');
                option.value = company.id;
                option.textContent = company.name;
                companySelect.appendChild(option);
            });
        });

    fetch('/api/categories')
        .then(response => response.json())
        .then(data => {
            const categorySelect = document.getElementById('category_id');

            data.forEach(category => {
                const option = document.createElement('option');
                option.value = category.id;
                option.textContent = category.name;
                categorySelect.appendChild(option);
            });
        });

    fetch('/api/tags')
        .then(response => response.json())
        .then(data => {
            const tagSelect = document.getElementById('tag_id');

            data.forEach(tag => {
                const option = document.createElement('option');
                option.value = tag.id;
                option.textContent = tag.name;
                tagSelect.appendChild(option);
            });
        });
});

// Update job
let currentJobId;
const openPopupButtons = document.querySelectorAll('.open-popup-button');
const popupOverlayEdit = document.getElementById('editJobPopup');
openPopupButtons.forEach(function (button) {
    button.addEventListener('click', function () {
        const jobId = this.getAttribute('data-id');
        console.log(jobId)
        const xhr = new XMLHttpRequest();
        const url = `api/jobs/${jobId}`;
        xhr.open('GET', url, 'true');

        xhr.onload = function () {
            if (xhr.status === 200) {
                const jobData = JSON.parse(xhr.responseText);
                console.log(jobData);

                const editUserIdInput = document.getElementById('editUserId');
                const editTypeSelect = document.getElementById('editType');
                const editEmailInput = document.getElementById('editEmail');
                const editFullnameInput = document.getElementById('editFullname');
                const editMajorInput = document.getElementById('editMajor');
                const editNameInput = document.getElementById('editName');

                editUserIdInput.value = userData.id;
                editNameInput.value = userData.name;
                editFullnameInput.value = userData.fullname;
                editMajorInput.value = userData.major;
                editEmailInput.value = userData.email;
                editTypeSelect.value = userData.type;

            } else {
                console.error('Failed to fetch User data');
            }
        }
        xhr.send();
        popupOverlayEdit.style.display = "block";
    });

});

popupOverlayEdit.addEventListener('click', (event) => {
    if (event.target === popupOverlayEdit) {
        popupOverlayEdit.style.display = 'none';
    }
});