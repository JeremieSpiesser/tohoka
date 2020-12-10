<?php

namespace App\Http\Controllers;

use App\Repositories\AnswerRepository;
use App\Repositories\InstanceRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

class AnswersAPIController extends Controller
{
    public function registerToInstance(Request $request){
        $idInstance = $request->post('idInstance');
        DB::table('answers')
            ->updateOrInsert(
                ['idInstance' => $idInstance, 'idPlayer' => Session::get('generic_user')->{'id'}],
                ['answers' => '{}']
            );

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
            return response()->json(['message' => "It's too late to respond to this question!"], 403);
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
    
    public function countAnswerPoints($idInstance, $idPlayer){
        $playerAnswer= json_decode(AnswerRepository::getPlayerAnswer($idInstance,$idPlayer),true);
        $realQuestion = json_decode(DB::table('quizzs')
            ->select('content')
            ->where('id',InstanceRepository::getQuizzId($idInstance))
            ->first()->content
            ,true)->items;
        
        $points=0;

        for ($i=0 ; i<count($realQuestion);i++){
            $realAns = realQuestion[i]->answer;
            $ans = playerAnswer[i];
            $r=count(ans);
            $a=count(realAns);
            for ($j=0; $j<min($r,$a);j++){
                if (realAns['bool'] && ans['bool']){
                    $points = $points + 1;
                }
            }
        }

       return $points; 
    }
}
