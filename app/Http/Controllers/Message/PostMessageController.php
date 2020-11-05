<?php


namespace App\Http\Controllers\Message;


use App\Events\Message\NewMessage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class PostMessageController
{
    function handle(Request $req){
        $posted = $req->input('msg');

        broadcast(new NewMessage(Session::get('chat_name', "ArgJeSuisUnProbleme:("), e($posted), Carbon::now()->locale('fr')->calendar()))->toOthers();
    }
}
