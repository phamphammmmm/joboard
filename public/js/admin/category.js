document.addEventListener('DOMContentLoaded', () => {
    const editCategoryButtons = document.querySelectorAll('.edit-category-btn');
    const popupOverlay = document.querySelector('.popup-overlay');
    const closeOverlayButton = document.querySelector('.close-overlay-button');
    const editCategoryForm = document.getElementById('editCategoryForm');
    const categoryIdInput = document.getElementById('category_id');
    const nameInput = document.getElementById('name');

    popupOverlay.addEventListener('click', (event) => {
        if (event.target === popupOverlay) {
            popupOverlay.style.display = 'none';
        }
    });

    editCategoryButtons.forEach((button) => {
        button.addEventListener('click', () => {
            const row = button.parentNode.parentNode;
            const categoryId = button.getAttribute('data-id');
            const categoryName = row.querySelector('.name').textContent;

            categoryIdInput.value = categoryId;
            nameInput.value = categoryName;

            popupOverlay.style.display = 'block';
        });
    });
});

//Add category popup
document.addEventListener('DOMContentLoaded', () => {
    // Lấy tham chiếu đến các phần tử
    const addCategoryBtn = document.getElementById('addCategoryBtn');
    const addCategoryPopup = document.getElementById('addCategoryPopup');
    const addCategoryForm = document.getElementById('addCategoryForm');

    // Xử lý sự kiện click để mở/đóng popup
    addCategoryBtn.addEventListener('click', () => {
        addCategoryPopup.style.display = 'block';
    });

    addCategoryPopup.addEventListener('click', (event) => {
        if (event.target === addCategoryPopup) {
            addCategoryPopup.style.display = 'none';
        }
    });

});
