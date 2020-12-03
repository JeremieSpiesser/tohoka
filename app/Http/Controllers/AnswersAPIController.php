<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\InstanceRepository;
use App\Models\Answers;
use Illuminate\Support\Facades\Auth;

class AnswersAPIController extends Controller
{
    public function registerToInstance(Request $request){
        $answer = new Answers();

        $answer->idInstance = $request->post('idInstance');
        $answer->idPlayer = Auth::id();

        $answer->timestamps = false;
        $answer->save();

        return QuizzsUIController::playquizz(InstanceRepository::getQuizzId($request->post('idInstance')), $request->post('idInstance'));
    }

    public function registerAnswer(Request $request){
        $answer = AnswerRepository::getPlayerAnswer($request->post('idInstance'), Auth::id())['content'];

        $array = json_decode($answer, true);
        $array[] = json_decode($request->post('answer'));

        $answer = json_encode($array);
        AnswerRepository::updateAnswer($request->post('idInstance'), Auth::id(), $answer);
    }
}
