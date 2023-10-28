
// $(function(){

//         var user_id = '{{Auth::id()}}';  
//         var other_user_id = '{{($otherUser)?$otherUser->id:''}}';   // if otherUser not exist, that is ''
//         var other_user_name = '{{($otherUser)?$otherUser->name:''}}';
//         var socket = io("http://localhost:3000", {query: {user_id: user_id}}); // establish a socket to node server and transfer user_id
        
//         $("#chat-form").on("submit", (err)=>{
//             err.preventDefault();
//             var message = $("#message-input").val(); // get value of message
//             // if remove space before and after message (trim() method) and length of message = 0 that's message is northing
//             if(message.trim().length == 0){
//                 // put cursor in input box
//                 $("#message-input").focus();
//             }
//             else {
//                 var data = {
//                     user_id: user_id,
//                     other_user_id: other_user_id,
//                     message: message,
//                     other_user_name: other_user_name
//                 };
//                 // send socket with event 'send_message'
//                 socket.emit('send_message', data);
//                 // remove message in input box
//                 $("#message-input").val('');
//             }
//         });

//         socket.on('user_connected', (data)=>{
//             // ReUpdate status from Off->On
//             $("#status_" + data).html('<span class="fa fa-circle chat-online"></span> Online');
//         });
//         socket.on('user_disconnected', (data)=>{
//             // ReUpdate status from On->Off
//             $("#status_" + data).html('<span class="fa fa-circle chat-offline"></span> Offline');
//         });
//         socket.on('receive_message', (data)=>{
//             console.log("recieve_message", data);
//             if((data.user_id == user_id && data.other_user_id == other_user_id) || (data.user_id == other_user_id && data.other_user_id == user_id)){
//                 if(data.user_id == user_id){
//                     var html = `<div class="chat-message-right pb-4">
//                                     <div>
//                                     <img src="https://ui-avatars.com/api/?name={{auth()->user()->name}}" class="rounded-circle mr-1" alt="Chris Wood" width="40" height="40" />
//                                         <div class="text-muted small text-nowrap mt-2">${data.time}</div>
//                                     </div>
//                                     <div class="flex-shrink-1 bg-light rounded py-2 px-3 mr-3">
//                                         <div class="font-weight-bold mb-1">You</div>
//                                         ${data.message}
//                                     </div>
//                                 </div>`;
//                 } else {
//                     socket.emit('read_message', data.id);
//                     var html = `<div class="chat-message-left pb-4">
//                                     <div>
//                                         <img src="https://ui-avatars.com/api/?name=${other_user_name}" class="rounded-circle mr-1" alt="Sharon Lessman" width="40" height="40" />
//                                         <div class="text-muted small text-nowrap mt-2">${data.time}</div>
//                                     </div>
//                                     <div class="flex-shrink-1 bg-light rounded py-2 px-3 ml-3">
//                                         <div class="font-weight-bold mb-1">${other_user_name}</div>
//                                         ${data.message}
//                                     </div>
//                                 </div>`;
//                 }
//                 $(".chat-messages").append(html);
//                 $(".chat-messages").animate({scrollTop:$(".chat-messages").prop("scrollHeight")}, 1000);
//             }
//             else {
//                 $("#unread-count-" + data.user_id).html('<div class="badge bg-success float-right">'+ data.unread_messages+'</div>');
//             }
//         });
// })