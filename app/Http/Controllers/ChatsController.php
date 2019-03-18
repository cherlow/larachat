<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use App\Events\MessageSent;
use App\Events\sendMessage;
use App\User;
use App\Chats;

class ChatsController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function index(){

        return view('chats');
    }
    
    public function fetchMessages(){

        return Message::with('user')->get();
    }

    public function sendMessage(Request $request){

        

    //    $message=new Message;
    //     $message->message=$request->message;
    //     $message->user_id=auth()->user()->id;
    //     $message->save();


        // broadcast(new MessageSent($message->load('user')))->toOthers();
    //     return ['status'=>'success'];

        

    }

    public function show(User $user){
       $messageto=$user;
       $messages=Message::where(function($query) use($messageto){
        $query->where('messenger_id',auth()->user()->id)
        ->where('messengarable_id',$messageto->id);
      })->orWhere(function($query) use($messageto){
        $query->where('messenger_id',$messageto->id)
        ->where('messengarable_id',auth()->user()->id);
      })->get();

      $auth=auth()->user();
      $user=User::find($user->id);


      return response([
        'messages'=> $messages,
        'user'=>$user,
        'auth'=>$auth,
    ]);

    }

    public function create(Request $request,User $user){

        $newmessage=new Message;
        $newmessage->message=$request->message;
        $newmessage->messenger_id=auth()->user()->id;
        $newmessage->messengarable_id=$user->id;
        $newmessage->save();
        
        $messageto=$user;
      

        $chat=Chats::where(function($query) use($messageto){
            $query->where('sender_id',auth()->user()->id)
            ->where('messengarable_id',$messageto->id);
          })->orWhere(function($query) use($messageto){
            $query->where('sender_id',$messageto->id)
            ->where('messengarable_id',auth()->user()->id);
          })->first();
          
          
       

      

          if($chat){
            $chat_id=$chat['id'];
            $chats=Chats::find($chat_id);
            
            $chats->sender_id=auth()->user()->id;
            $chats->messengarable_id=$user->id;
            $chats->sender_name=auth()->user()->name;
            $chats->messengarable_name=$user->name;
            $chats->latest_message=$request->message;
            $chats->save();
            
          }
          else{
            $chats=New Chats;
            $chats->sender_id=auth()->user()->id;
            $chats->messengarable_id=$user->id;
            $chats->sender_name=auth()->user()->name;
            $chats->messengarable_name=$user->name;
            $chats->latest_message=$request->message;
            $chats->save();
            
          }

          broadcast(new SendMessage($newmessage,$user))->toOthers();
         

    }
}
