
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

});
