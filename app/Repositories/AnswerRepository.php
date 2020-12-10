<?php


namespace App\Repositories;


use App\Core\App;
use App\Models\Answers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Class AnswerRepository
 * @package App\Repositories
 */
class AnswerRepository
{
    public static function getPlayerAnswer($idInstance, $idPlayer){
        return Answers::select('answers')
            ->where('idInstance', $idInstance)
            ->where('idPlayer', $idPlayer)
            ->first()->answers;
    }

    public static function updateAnswer($idInstance, $idPlayer, $newAnswer){
        return DB::table('answers')
            ->where('idInstance', $idInstance)
            ->where('idPlayer', $idPlayer)
            ->update(['answers' => $newAnswer]);
    }

    public static function countAnswerPoints($idInstance, $idPlayer){
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
