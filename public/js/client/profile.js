document.addEventListener('DOMContentLoaded', () => {
    const editProfileBtn = document.getElementById('edit-profile-btn');
    const editProfilePopup = document.getElementById('Edit-Profile-Popup');
    const editProfileForm = document.getElementById('Edit-Profile-Form');

    editProfileBtn.addEventListener('click', () => {
        editProfilePopup.style.display = 'block';
    });

    editProfilePopup.addEventListener('click', (event) => {
        if (event.target === editProfilePopup) {
            editProfilePopup.style.display = 'none';
        }
    });

    editProfileBtn.addEventListener('click', function () {
        const userId = this.getAttribute('data-id');
        const xhr = new XMLHttpRequest();
        const url = `/api/user/${userId}`;
        xhr.open('GET', url, true);

        xhr.onload = function () {
            if (xhr.status === 200) {
                const userData = JSON.parse(xhr.responseText);

                const editUserIdInput = document.getElementById('editUserId');
                const editEmailInput = document.getElementById('editEmail');
                const editFullnameInput = document.getElementById('editFullname');
                const editMajorInput = document.getElementById('editMajor');
                const editNameInput = document.getElementById('editName');
                const editDescriptionInput = document.getElementById('editDescription');
                const editLocationInput = document.getElementById('editLocation');

                editUserIdInput.value = userData.id;
                editNameInput.value = userData.name;
                editFullnameInput.value = userData.fullname;
                editMajorInput.value = userData.major;
                if (userData.desciption !== null) {
                    editDescriptionInput.value = userData.description;
                } else {
                    editDescriptionInput.value = '';
                }

                if (userData.location !== null) {
                    editLocationInput.value = userData.location;
                } else {
                    editLocationInput.value = '';
                }
                editEmailInput.value = userData.email;

                editProfilePopup.style.display = "block";
            } else {
                console.error('Failed to fetch User data');
            }
        }

        xhr.send();
    });
});
