var sidebarToggleBtn = document.getElementById('sidebar-toggle');
var leftSidebar = document.querySelector('.left_sidebar');
var content = document.querySelector('.content');

sidebarToggleBtn.addEventListener('click', function () {
    leftSidebar.classList.toggle('sidebar-hidden');
    if (leftSidebar.classList.contains('sidebar-hidden')) {
        content.style.marginLeft = '0';
        content.style.width = '100%';
    } else {
        content.style.marginLeft = '7%';
        content.style.width = '93%';
    }
});

$(document).ready(function () {
    $('.left_sidebar').on('click', 'a.ajax-link', function (event) {
        event.preventDefault();

        var url = $(this).attr('href');

        $.ajax({
            url: url,
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                $('#content-container').html(response);
            },
            error: function (xhr, status, error) {
                console.log(error);
            }
        });
    });
});

// Mode light/dark
function toggleDarkMode() {
    const body = document.body;
    body.classList.toggle('dark-mode');
    // Save user preference to local storage
    const isDarkMode = body.classList.contains('dark-mode');
    localStorage.setItem('dark-mode', isDarkMode);
}

// Thêm sự kiện cho nút chuyển đổi
const darkModeToggle = document.getElementById('dark-mode-toggle');
darkModeToggle.addEventListener('click', toggleDarkMode);

// Kiểm tra xem người dùng đã chọn chế độ tối trước đó
const isDarkModePreferred = localStorage.getItem('dark-mode') === 'true';
if (isDarkModePreferred) {
    document.body.classList.add('dark-mode');
}
