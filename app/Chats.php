<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chats extends Model
{
    protected $fillabe=[
        'sender_id', 'messengarable_id','sender_name','messengarable_name','latest_message'
    ];
}
