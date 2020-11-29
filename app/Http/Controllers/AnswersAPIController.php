<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Answers;
use Illuminate\Support\Facades\Auth;

class AnswersAPIController extends Controller
{
    public function registerPlayer(Request $request){
        $answer = new Answers();

        //$answer->idInstance = registerToInstance($request->get('idInstance')); TODO : implement registerToInstance function to check authorizatoin
        $answer->idInstance = $request->get('idInstance');
        $answer->idPlayer = Auth::id();
        //$answer->answers = $request->post('answers');

        $answer->timestamps = false;
        $answer->save();
    }

    public function registerAnswer(Request $request){
        $answer = AnswerRepository::getPlayerAnswer($request->get('idInstance'), Auth::id())['content'];
        var_dump($answer);
    }
}
