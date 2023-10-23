document.addEventListener('DOMContentLoaded', function () {
    const messages = document.getElementById('messages');
    const messageInput = document.getElementById('message');
    const sendButton = document.getElementById('send');

    sendButton.addEventListener('click', function () {
        const userMessage = messageInput.value;
        appendMessage('You', userMessage);
        sendMessageToAI(userMessage);
        messageInput.value = '';
    });

    function appendMessage(sender, message) {
        const messageDiv = document.createElement('div');
        messageDiv.textContent = `${sender}: ${message}`;
        messages.appendChild(messageDiv);
    }

    function sendMessageToAI(message) {
        // Gửi yêu cầu API đến OpenAI
        // Sử dụng API key và message

        // Nhận phản hồi từ OpenAI và hiển thị nó
        const aiMessage = 'AI response'; // Thay bằng phản hồi từ OpenAI
        appendMessage('AI', aiMessage);
    }
});
