<?php

namespace App\Http\Controllers\front;

use App\Events\NewMessage;
use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class ChatController extends Controller
{
    public function index()
    {

       return Inertia::render('front/chat/index', ['chats'=>Auth::user()->chats->load('users')->reverse()]);
    }

    public function getConversation(Chat $chat)
    {
        if (! Gate::allows('get-conversation', $chat)) {
            abort(403);
        }
       $messages = Message::where('chat_id', $chat->id)->with('sender')->orderBy('created_at', 'ASC')->get();

       return Inertia::render('front/chat/Conversation', ['chat'=>$chat, 'messages'=>$messages]);
    }

    public function newMessage(Chat $chat, Request $request)
    {
        $request->validate([
            // 'to_id'=>'required|numeric',
            'content'=>'required|string|max:250',
        ]);
        $newMessage = new Message();
        $newMessage->chat_id = $chat->id;
        $newMessage->from_id = Auth::id();
        // $newMessage->to_id = $request->to_id;
        $newMessage->content = $request->content;
        $newMessage->save();

        broadcast(new NewMessage($newMessage))->toOthers();

        return redirect()->back();
    }

    public function connectConversation(User $user)
    {
        if (Gate::allows('not-to-yourself', $user)) {
            abort(403);
        }
        $chat = Chat::whereHas('users', function ($query) use ($user){
            $query->where('users.id', Auth::user()->id);
        })->whereHas('users', function ($query) use ($user){
            $query->where('users.id', $user->id);
        })->first();

        if (!$chat) {
            $chat = new Chat();
            $chat->save();
            $chat->users()->attach([Auth::user()->id, $user->id]);
        }

        return redirect()->route('get.conversation', $chat);
    }
}
