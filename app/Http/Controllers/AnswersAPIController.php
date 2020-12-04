<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\InstanceRepository;
use App\Repositories\AnswerRepository;
use App\Models\Answers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $answer = DB::table('answers')
            ->select('answers')
            ->where('idInstance', $request->post('idInstance'))
            ->where('idPlayer', Auth::id())
            ->first()
            ->answers;

        $array = json_decode($answer, true);
        $array[$request->post('idQuestion')] = json_decode($request->post('answer'), true);

        $answer = json_encode($array);
        AnswerRepository::updateAnswer($request->post('idInstance'), Auth::id(), $answer);
    }
}
