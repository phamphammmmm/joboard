<div id="received-messages"></div>
<script>
const receivedMessagesContainer = document.getElementById('received-messages');

const channel = pusher.subscribe('chat');
channel.bind('App\\Events\\NewMessage', function(data) {
    receivedMessagesContainer.innerHTML += '<p>' + data.message + '</p>';
});
</script>