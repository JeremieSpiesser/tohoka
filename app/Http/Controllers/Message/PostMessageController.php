<?php


namespace App\Http\Controllers\Message;


use App\Events\Message\NewMessage;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Session;
use Str;

class PostMessageController
{
    function handle(Request $req){
        $posted = $req->input('msg');

        if(Session::has('generic_user') && Session::has('current_room') && !empty($posted)){
            broadcast(new NewMessage(Session::get('generic_user')->id, e($posted), Carbon::now()->locale('fr')->calendar(), Session::get('current_room')));
            return 'ok';
        }

        return 'not-broadcasted';
    }
}
