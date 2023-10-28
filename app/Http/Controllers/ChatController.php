<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\View\View;
use Auth;
use App\Models\User;
use App\Models\Chat;
use DB;

class ChatController extends Controller
{
    public function chat(REQUEST $request, $id = NULL){
        $messages = [];
        $otherUser = NULL;
        $user_id = Auth::id(); // id nguoi dang nhap
        if($id){
            $otherUser = User::findOrFail($id);
            $group_id = (Auth::id()>$id)?Auth::id().$id:$id.Auth::id();
            $messages = Chat::where('group_id', $group_id)->get()->toArray();
            Chat::where(['user_id'=>$id, 'other_user_id'=>$user_id, 'is_read'=>0])->update(['is_read'=>1]);
        }
        $friends = User::where('id', '!=', Auth:: id())->select('*', DB::raw("(SELECT count(id) from chats 
        where chats.other_user_id=$user_id and chats.user_id = users.id and is_read = 0) as unread_messages"))->get()->toArray();
        // dd($user_id);
        return view('client.chat', compact('friends', 'messages', 'otherUser', 'id'));
    }
}