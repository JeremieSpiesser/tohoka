<?php

namespace App\Http\Controllers;

use App\Models\Answers;
use App\Repositories\AnswerRepository;
use App\Repositories\InstanceRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

class AnswersAPIController extends Controller
{
    public function registerToInstance(Request $request, $idInstance){
        $ans = new Answers();
        $ans->idInstance = $idInstance;
        $ans->idPlayer = Session::get('generic_user')->{'id'};
        $ans->answers = '[]';

        $ans->save();

        $masterId = DB::table('instances')
            ->select(['master'])
            ->where('id', $idInstance)
            ->first()
            ->master;

        Session::put('current_instance', $idInstance);

        return QuizzsUIController::playquizz(InstanceRepository::getQuizzId($idInstance), $masterId, $idInstance);
    }

    public function registerAnswer(Request $request){

        $instanceId = $request->post('idInstance');
        $questionId = $request->post('idQuestion');

        switch(InstanceRepository::canAcceptAnswer($instanceId, $questionId)){
        case -1:
            return response()->json(['message' => "You can't respond to this question right now!"], 403);
            break;
        case 1:
            //return response()->json(['message' => "It's too late to respond to this question!"], 403);
            break;
        case 0:
            break;
        }
        $answer = DB::table('answers')
            ->select('answers')
            ->where('idInstance', $instanceId)
            ->where('idPlayer', Session::get('generic_user')->{'id'})
            ->first()
            ->answers;

        $array = json_decode($answer, true);
        $array[$questionId] = json_decode($request->post('answer'), true);

        $answer = json_encode($array);
        AnswerRepository::updateAnswer($instanceId, Session::get('generic_user')->{'id'}, $answer);
    }
}
