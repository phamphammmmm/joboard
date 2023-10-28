<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.6.0/socket.io.min.js"></script>
</head>
<body>
    @extends('layout')
    @section('title', 'Trang chủ')
    @section('content')
    <div id="snippetContent"> 
        <main class="content">
            <div class="container p-0"> 
                <div class="card">
                    <div class="row g-0">
                        <div class="col-12 col-lg-5 col-xl-3 border-right"> 
                            @foreach($friends as $friend)
                            <a href="{{route('chat', $friend['id'])}}" class="list-group-item list-group-item-action border-0">
                                <div id="unread-count-{{$friend['id']}}">
                                    @if($friend['unread_messages'] > 0)
                                    <div class="badge bg-success float-right">{{$friend['unread_messages']}}</div>
                                    @endif
                                </div>
                                <div class="d-flex align-items-start">
                                    <img src="https://ui-avatars.com/api/?name={{$friend['name']}}" class="rounded-circle mr-1" alt="Vanessa Tucker" width="40" height="40" />
                                    <div class="flex-grow-1 ml-3">
                                        {{$friend['name']}}
                                        <div class="small" id="status_{{$friend['id']}}">
                                            @if($friend['is_online'] == 1)
                                            <span class="fa fa-circle chat-online"></span> Onine
                                            @else
                                            <span class="fa fa-circle chat-offline"></span> Offline
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </a>
                            @endforeach
                            <hr class="d-block d-lg-none mt-1 mb-0" />
                        </div>
                        <div class="col-12 col-lg-7 col-xl-9">
                            <!-- if click into friend  -->
                            @if($id)
                            <div class="py-2 px-4 border-bottom d-none d-lg-block">
                                <div class="d-flex align-items-center py-1">
                                    <div class="position-relative"><img src="https://ui-avatars.com/api/?name={{$otherUser->name}}" class="rounded-circle mr-1" alt="Sharon Lessman" width="40" height="40" /></div>
                                    <div class="flex-grow-1 pl-3">
                                        <strong>{{$otherUser->name}}</strong>
                                        <!-- <div class="text-muted small"><em>Typing...</em></div> -->
                                    </div> 
                                </div>
                            </div>
                            <!-- message  -->
                            <div class="position-relative">
                                <div class="chat-messages p-4">
                                    @foreach($messages as $message)
                                    @if($message['user_id'] == Auth::id())
                                    <div class="chat-message-right pb-4">
                                        <div>
                                        <img src="https://ui-avatars.com/api/?name={{auth()->user()->name}}" class="rounded-circle mr-1" alt="Chris Wood" width="40" height="40" />
                                            <div class="text-muted small text-nowrap mt-2">{{date("h:i A", strtotime($message['created_at']))}}</div>
                                        </div>
                                        <div class="flex-shrink-1 bg-light rounded py-2 px-3 mr-3">
                                            <div class="font-weight-bold mb-1">You</div>
                                            {{$message['messages']}}
                                        </div>
                                    </div>
                                    @else
                                    <div class="chat-message-left pb-4">
                                        <div>
                                            <img src="https://ui-avatars.com/api/?name={{$otherUser->name}}" class="rounded-circle mr-1" alt="Sharon Lessman" width="40" height="40" />
                                            <div class="text-muted small text-nowrap mt-2">{{date("h:i A", strtotime($message['created_at']))}}</div>
                                        </div>
                                        <div class="flex-shrink-1 bg-light rounded py-2 px-3 ml-3">
                                            <div class="font-weight-bold mb-1">{{$otherUser->name}}</div>
                                            {{$message['messages']}}
                                        </div>
                                    </div>
                                    @endif
                                    @endforeach
                                </div>
                            </div>
                            <div class="flex-grow-0 py-3 px-4 border-top">
                                <form action="" id="chat-form">
                                    <div class="input-group">
                                        <input type="text" id="message-input" class="form-control" placeholder="Type your message"/> 
                                        <button class="btn btn-primary" type="submit">Send</button>
                                    </div>
                                </form>
                            </div>
                            @else
                        
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </main> 
    </div>

    @endsection

<style type="text/css">
    body {
        margin-top: 20px;
    }

    .chat-online {
        color: #34ce57;
    }

    .chat-offline {
        color: #e4606d;
    }

    .chat-messages {
        display: flex;
        flex-direction: column;
        max-height: 800px;
        overflow-y: scroll;
    }

    .chat-message-left,
    .chat-message-right {
        display: flex;
        flex-shrink: 0;
    }

    .chat-message-left {
        margin-right: auto;
    }

    .chat-message-right {
        flex-direction: row-reverse;
        margin-left: auto;
    }
    .py-3 {
        padding-top: 1rem !important;
        padding-bottom: 1rem !important;
    }
    .px-4 {
        padding-right: 1.5rem !important;
        padding-left: 1.5rem !important;
    }
    .flex-grow-0 {
        flex-grow: 0 !important;
    }
    .border-top {
        border-top: 1px solid #dee2e6 !important;
    }
</style>

</body>
</html>

<script>
    $(function(){
        var user_id = '{{Auth::id()}}';  
        var other_user_id = '{{($otherUser)?$otherUser->id:''}}';   // if otherUser not exist, that is ''
        var other_user_name = '{{($otherUser)?$otherUser->name:''}}';
        var socket = io("http://localhost:3000", {query: {user_id: user_id}}); // establish a socket to node server and transfer user_id
        
        $("#chat-form").on("submit", (err)=>{
            err.preventDefault();
            var message = $("#message-input").val(); // get value of message
            // if remove space before and after message (trim() method) and length of message = 0 that's message is northing
            if(message.trim().length == 0){
                // put cursor in input box
                $("#message-input").focus();
            }
            else {
                var data = {
                    user_id: user_id,
                    other_user_id: other_user_id,
                    message: message,
                    other_user_name: other_user_name
                };
                // send socket with event 'send_message'
                socket.emit('send_message', data);
                // remove message in input box
                $("#message-input").val('');
            }
        });

        socket.on('user_connected', (data)=>{
            // ReUpdate status from Off->On
            $("#status_" + data).html('<span class="fa fa-circle chat-online"></span> Online');
        });
        socket.on('user_disconnected', (data)=>{
            // ReUpdate status from On->Off
            $("#status_" + data).html('<span class="fa fa-circle chat-offline"></span> Offline');
        });
        socket.on('receive_message', (data)=>{
            console.log("recieve_message", data);
            if((data.user_id == user_id && data.other_user_id == other_user_id) || (data.user_id == other_user_id && data.other_user_id == user_id)){
                if(data.user_id == user_id){
                    var html = `<div class="chat-message-right pb-4">
                                    <div>
                                    <img src="https://ui-avatars.com/api/?name={{auth()->user()->name}}" class="rounded-circle mr-1" alt="Chris Wood" width="40" height="40" />
                                        <div class="text-muted small text-nowrap mt-2">${data.time}</div>
                                    </div>
                                    <div class="flex-shrink-1 bg-light rounded py-2 px-3 mr-3">
                                        <div class="font-weight-bold mb-1">You</div>
                                        ${data.message}
                                    </div>
                                </div>`;
                } else {
                    socket.emit('read_message', data.id);
                    var html = `<div class="chat-message-left pb-4">
                                    <div>
                                        <img src="https://ui-avatars.com/api/?name=${other_user_name}" class="rounded-circle mr-1" alt="Sharon Lessman" width="40" height="40" />
                                        <div class="text-muted small text-nowrap mt-2">${data.time}</div>
                                    </div>
                                    <div class="flex-shrink-1 bg-light rounded py-2 px-3 ml-3">
                                        <div class="font-weight-bold mb-1">${other_user_name}</div>
                                        ${data.message}
                                    </div>
                                </div>`;
                }
                $(".chat-messages").append(html);
                $(".chat-messages").animate({scrollTop:$(".chat-messages").prop("scrollHeight")}, 1000);
            }
            else {
                $("#unread-count-" + data.user_id).html('<div class="badge bg-success float-right">'+ data.unread_messages+'</div>');
            }
        });
    })
</script>
