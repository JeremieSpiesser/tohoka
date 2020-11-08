<?php


namespace App\Http\Controllers\Message;


use App\Events\Message\NewMessage;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Session;

class PostMessageController
{
    function handle(Request $req){
        $posted = $req->input('msg');

        if(Session::has('public_room_user_id')){
            broadcast(new NewMessage(Session::get('public_room_user_id'), e($posted), Carbon::now()->locale('fr')->calendar()));
            return 'ok';
        }

        return 'not-broadcasted';
    }
}
