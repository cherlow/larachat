<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Message extends Model
{
    //fillables
    protected $fillables=[
        'message'
    ];


    public function user(){
        return $this->belongsTo(User::class);
    }
}
