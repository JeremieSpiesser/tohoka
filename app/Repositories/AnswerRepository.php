<?php


namespace App\Repositories;


use App\Core\App;
use App\Models\Answers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Events\UserStateChanged;
use Session;

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
        $playerAnswers= json_decode(AnswerRepository::getPlayerAnswer($idInstance,$idPlayer),true);
        $realQuestions = json_decode(DB::table('quizzs')
            ->select('content')
            ->where('id',InstanceRepository::getQuizzId($idInstance))
            ->first()->content
            ,true)['items'];

        $points = 0;
        $total = 0;

        for($quest = 0; $quest < count($realQuestions); $quest++){
            $partialPoint = 0;
            $realQuest = $realQuestions[$quest];
            $playerQuest = $playerAnswers[$quest];

            switch ($realQuest['type']){
                case 'classic':
                    $partialPoint += $realQuest['answers'][$playerQuest[0]]['bool'] ? 1 : 0;
                    $total++;
                    break;
                case 'qcma':
                case 'qcm':
                    for($qcm = 0; $qcm < count($realQuest['answers']); $qcm++){
                        if(!array_key_exists($qcm, $playerQuest) || $playerQuest[$qcm] === null){
                            $playerQuest[$qcm] = false;
                        }

                        if($realQuest['answers'][$qcm]['bool']){
                            $partialPoint += $playerQuest[$qcm] == $realQuest['answers'][$qcm]['bool'] ? 1 : 0;
                        }else{
                            $partialPoint += $playerQuest[$qcm] == $realQuest['answers'][$qcm]['bool'] ? 0 : -1;
                        }
                        $total += $realQuest['answers'][$qcm]['bool'] ? 1 : 0;
                    }
                    break;
                case 'tf':
                    $partialPoint += $playerQuest[0] == $realQuest['isTrue'] ? 1 : -1;
                    $total++;
                    break;
            }

            if($partialPoint < 0){
                $partialPoint = 0;
            }

            $points += $partialPoint;
        }

       return [$points, $total];
    }

    public static function sendAnswers()
    {
        $idInstance = Session::get('current_instance');
        $answers = DB::table('answers')
            ->where('idInstance', $idInstance)
            ->get();

        foreach($answers as $answer){
            [$points, $max] = AnswerRepository::countAnswerPoints($idInstance, $answer->idPlayer);
            broadcast(new UserStateChanged($idInstance, $answer->idPlayer, "Score : $points/$max"));
        }

        return \Response::json(['status' => 'ok']);
    }
}
