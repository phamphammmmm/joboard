<!DOCTYPE html>
<html>

<head>
    <title>Message Display</title>
</head>

<body>
    <h1>Received Message:</h1>
    <div id="message-container"></div>

    <form id="message-form" method="post" enctype="multipart/form-data">
        @csrf
        @method('POST')
        <input type="text" id="message-input" placeholder="Type your message...">
        <button type="submit">Send</button>
    </form>

    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script>
    const pusher = new Pusher('84edbb8be57c52b1a11b', {
        cluster: 'ap1',
        encrypted: true
    });

    const channel = pusher.subscribe('chat');
    channel.bind('App\\Events\\NewMessage', function(data) {
        const messageContainer = document.getElementById('message-container');
        messageContainer.innerHTML += '<p>' + data.message + '</p>';
    });

    document.getElementById('message-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const messageInput = document.getElementById('message-input');
        const message = messageInput.value;
        messageInput.value = '';

        axios.post('/send-message', {
                message: message
            })
            .then(function(response) {
                console.log(response.data);
            })
            .catch(function(error) {
                console.error(error);
            });
    });
    </script>
</body>

</html>