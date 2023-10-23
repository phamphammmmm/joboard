import './bootstrap';

window.Echo = new Echo({
    broadcaster: 'socket.io',
    host: window.location.hostname + ':6001', // Thay đổi port nếu bạn đã chọn một cổng khác
});
